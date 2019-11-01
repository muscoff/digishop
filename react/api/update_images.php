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
	$product->id  = sanitize_text($_POST['id']);
	$single = $product->fetch_single();
	$img = $single['image'];
	$explode = explode(',', $img);
	$limit = 4 - count($explode);
	$img = $img.',';
	$image = null;
	$json = null;
	$db = url_location.'images/product';
	$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/product";
	$tmp = array();
	$final = array();
	if(isset($_FILES['images']) & !empty($_FILES['images']['name'][0])){
		$image = multiple_images($_FILES['images'], $limit, $db, $server);
		$set = $image;
		foreach ($set as $key => $setValue) {
			$img = $img.$setValue['db_location'].',';
			array_push($tmp, $setValue['tmp']);
			array_push($final, $setValue['server_location']);
		}
		$img = rtrim($img, ',');
		$product->image = $img;
	}

	if(!empty($tmp)){
		$truth = move_files($tmp, $final);
		if(in_array(false, $truth)){
			echo_json(array('msg'=>'failed'));
		}else{
			if($product->update_images()){
				echo_json(array('msg'=>'success'));
			}else{
				$len = count($final);
				for($i=0; $i<$len; $i++){
					unlink($final[$i]);
				}
				echo_json(array('msg'=>'update failed'));
			}
		}
	}else{
		echo_json(array('msg'=>'failed'));
	}
}

if(isset($_GET['id'])){
	$product->id = sanitize_text($_GET['id']);
	$productImage = sanitize_text($_GET['img']);
	$explodeImage = explode('/', $productImage);
	$delete = end($explodeImage);
	$delete = $_SERVER['DOCUMENT_ROOT']."/digishop/images/product/".$delete;
	$single = $product->fetch_single();
	$image = $single['image'];
	$explode = explode(',', $image);
	$imgArray = array();
	$string = '';
	foreach ($explode as $key => $img) {
		if($img !== $productImage){
			$string = $string.$img.',';
			array_push($imgArray, $img);
		}
	}
	$string = rtrim($string, ',');
	$product->image = $string;
	
	if($product->delete_single_image()){
		unlink($delete);
		echo_json(array('msg'=>'removed'));
	}else{
		echo_json(array('msg'=>'failed to delete'));
	}
}

if(isset($_GET['productId'])){
	$product->id = sanitize_text($_GET['productId']);
	$image = sanitize_text($_GET['img']);
	$single = $product->fetch_single();
	$string = '';
	$img = explode(',', $single['image']);
	foreach ($img as $key => $newImage) {
		if($newImage !== $image){
			$string = $string.$newImage.',';
		}
	}
	$string = rtrim($string, ',');
	$string = $image.','.$string;
	$product->image = $string;

	if($product->product_face()){
		echo_json(array('msg'=>'product face updated'));
	}else{
		echo_json(array('msg'=>'failed to update product face'));
	}
}