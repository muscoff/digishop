<?php  
header("Access-Control-Allow-Origin: *");
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Product.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/libraries/lib.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

// initialize db
$DBH = new DB();
$db = $DBH->connect();

//initialize product
$product = new Product($db);

if(isset($_POST['id'])){
	$product->id = sanitize_text($_POST['id']);
	$product->title = sanitize_text($_POST['title']);
	$product->brand = sanitize_text($_POST['brand']);
	$product->parent_cat = sanitize_text($_POST['parent']);
	$product->child_cat = sanitize_text($_POST['child']);
	$product->price = sanitize_text($_POST['price']);
	$sizes = rtrim($_POST['sizes'], ',');
	$product->sizes = sanitize_text($sizes);
	$product->description = sanitize_text($_POST['description']);

	if($product->edit()){
		echo_json(array('msg'=>'updated successfully'));
	}else{
		echo_json(array('msg'=>'update failed'));
	}
}
elseif(isset($_POST['title'])){
	$tmp = array();
	$serverinfo = array();
	$string = '';

	$title = sanitize_text($_POST['title']);
	$brand = sanitize_text($_POST['brand']);
	$parent = sanitize_text($_POST['parent']);
	$child = sanitize_text($_POST['child']);
	$price = sanitize_text($_POST['price']);
	$sizes = rtrim($_POST['sizes'], ',');
	$sizes = sanitize_text($sizes);
	$description = sanitize_text($_POST['description']);

	//initialize
	$product->title = $title;
	$product->price = $price;
	$product->brand = $brand;
	$product->parent_cat = $parent;
	$product->child_cat = $child;
	$product->sizes = $sizes;
	$product->description = $description;

	$check = false;

	$images = null;
	if(isset($_FILES['images'])){
		$limit = 4;
		$db = url_location.'images/product';
		$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/product";
		$images = multiple_images($_FILES['images'], $limit, $db, $server); //multiple_images accepts limit, db, and server locations

		if(!is_null($images)){
			if(is_array($images) & !empty($images)){
				foreach ($images as $key => $value) {
					$string.= $value['db_location'].',';
					array_push($serverinfo, $value['server_location']);
					array_push($tmp, $value['tmp']);
				}
				$string = rtrim($string, ',');

				// initial image
				$product->image = $string;

				$truth = array();
				$toremove = $serverinfo;
				$failed = $serverinfo;

				$count = count($serverinfo);
				for($i=0; $i<$count; $i++){
					if(move_uploaded_file($tmp[$i], $serverinfo[$i])){
						array_push($truth, true);
					}else{
						array_push($truth, false);
					}
				}
				if(in_array(false, $truth)){
					foreach ($toremove as $key => $remove) {
						unlink($remove);
					}
					echo_json($array('damn'));
				}else{
					$result = $product->add();

					if($result['msg'] == 'success'){
					echo_json(array('msg'=>$result['msg']));
					}else{
						foreach ($failed as $key => $fail) {
							unlink($fail);
						}
						$myVal = [$product->title, $product->brand, $product->parent_cat, $product->price, $product->image, $product->description, $product->sizes, $product->child_cat];
						$newVal = return_json($myVal);
						echo_json(array('msg'=>$result['msg']));
					}
				}
			}else{
				echo_json(array('msg'=>'Accepted image size is 2MB or less. Please upload an image'));
			}
		}else{
			echo_json(array('msg'=>'At least a product image must be uploaded'));
		}
	}

}

if(isset($_GET['single'])){
	$id = sanitize_text($_GET['single']);
	$product->id = $id;

	$sizeArray = array();

	$single = $product->fetch_single();
	$sizes = $single['sizes'];
	$explodeSize = explode(',', $sizes);

	foreach ($explodeSize as $key => $size) {
		$explodeValue = explode(':', $size);
		$s = $explodeValue[0]; //size 
		$next = explode('-', $explodeValue[1]);
		$l = $next[0]; // length
		$q = (int)$next[1]; // quantity
		$arr = array('size'=>$s, 'len'=>$l, 'quantity'=>$q);
		array_push($sizeArray, $arr);
	}

	$single['sizes'] = $sizeArray;

	$image = $single['image'];
	$explodeImage = explode(',', $image);

	$single['image'] = $explodeImage;

	echo_json($single);
}

if(isset($_GET['featured']) & isset($_GET['id'])){
	$product->id = sanitize_text($_GET['id']);
	$product->featured = sanitize_text($_GET['featured']);

	if($product->updateFeatured()){
		echo_json(array('msg'=>'updated'));
	}else{
	echo_json(array('msg'=>'failed to update'));
	}
}
elseif(isset($_GET['id'])){
	$id = $_GET['id'];
	$product->id = $id;

	$single = $product->fetch_single();
	$image = $single['image'];

	//explode image
	$explodeImage = explode(',', $image);

	$imageArray = array();
	$name = array();
	foreach ($explodeImage as $key => $Imagevalue) {
		array_push($imageArray, $Imagevalue);
	}

	foreach ($imageArray as $key => $img) {
		$explode = explode('/', $img);
		$image_value = end($explode);
		array_push($name, $image_value);
	}

	if($product->delete()){
		foreach ($name as $key => $value) {
			$delete = $_SERVER['DOCUMENT_ROOT']."/digishop/images/product/".$value;
			unlink($delete);
		}
		echo_json(array('msg'=>'deleted'));
	}else{
		echo_json(array('msg'=>'failed to delete'));
	}
}