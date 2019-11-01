<?php  
//header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Product.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

// Database
$DBH = new DB();
$db = $DBH->connect();

// Product
$product = new Product($db);

$url = $_SERVER['HTTP_REFERER'];

$explode = explode('?', $url);

$url = $explode[0];

if(isset($_POST['productId'])){
	$id = $_POST['productId'];

	//Get any available image in database
	$data = json_decode(file_get_contents(url_location.'api/product/fetch_single.php?productId='.$id),true);
	$fetchImage = $data['image'];

	$product->id = $id;
	
	if(isset($_FILES) && !empty($_FILES['photo']['name'][0])){
		$count = count($_FILES['photo']['name']); // number of $_FILES['photo']['name'] received
		$img_name = array();	//img name
		$img_type = array();	//img type = jpg, jpeg, or png
		$img_temp = array();	//temporal location of files before it is moved
		$img_move = array();	//server location of files to be moved
		$truth = array(); 		// for our ultimate validation before we update database
		$db_img = '';			// string which I would update in database table
		$max_size = 2097152; 	//Standard Size = Max size
		$typeStack = ["image/png", "image/jpeg", "image/jpg"]; //array to compare img type with

		for($i = 0; $i < $count; $i++){
			if($_FILES['photo']['name'][$i] !=''){
				if($_FILES['photo']['size'][$i] <= $max_size){
					if($_FILES['photo']['error'][$i] !=1){
						if(in_array($_FILES['photo']['type'][$i], $typeStack)){
							$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/product/"; //location to use for server
							$rand = rand(1,1000000); // Generate random number

							$imgExplode = explode('.', $_FILES['photo']['name'][$i]);
							$name = $imgExplode[0]; // photo name
							$ext = $imgExplode[1];	//photo ext

							$image = md5($rand.$name).'.'.$ext;
							$db_image = img_folder.$image;
							$serverImage = $server.$image;
							array_push($img_name, $db_image);
							array_push($img_type, $_FILES['photo']['type'][$i]);
							array_push($img_temp, $_FILES['photo']['tmp_name'][$i]);
							array_push($img_move, $serverImage);
						}else{
							$msg = 'Please make sure to submit an image and not pdf. If this problem persist, please contact admin to rectify it for you. email: muscoff2008@gmail.com';
							header('Location: '.$url."?msg=".$msg."&productId=".$id);
							die();
						}//End of checking if the type matches the required type
					}else{
						$msg = 'Please check the image and make sure its not above 2MB';
						header('Location: '.$url."?msg=".$msg."&productId=".$id);
						die();
					}//Error so check image size
				}else{
					$msg = 'Your image might be bigger than the required size. Maximum size should be 2MB';
					header('Location: '.$url."?msg=".$msg."&productId=".$id);
					die();
				}//End of checking if the image size is bigger than our required expected size
			}else{
				continue;
				// $msg = 'No image found';
				// header('Location: '.$url."?msg=".$msg."&productId=".$id);
			}//Checking to make sure that at least an image name exist
		}//End of For Loop

		//Prepare image name for db,
		foreach ($img_name as $img) {
			$db_img = $db_img.$img.',';
		}

		$db_img = rtrim($db_img, ',');

		if(!empty($fetchImage)){
			$db_img = $fetchImage.','.$db_img;
		}else{
			$db_img = $db_img;
		}

		$countMove = count($img_move);

		for($j = 0; $j < $countMove; $j++){
			if(move_uploaded_file($img_temp[$j], $img_move[$j])){
				array_push($truth, true);
			}else{
				array_push($truth, false);
			}
		}

		if(in_array(false, $truth)){
			foreach($img_move as $move){
				unlink($move);
			}
			header('Location: '.$url."?productId=".$id."&msg=File was not moved, check the file type or consult admin");
		}else{
			$product->image = $db_img; // db image for update
			if($product->update_images()){
				header('Location: '.$url."?productId=".$id);
			}else{
				foreach ($img_move as $img_moved) {
					unlink($img_moved);
				}
				header('Location: '.$url."?productId=".$id."&msg=Failed to update");
			}
		}
	}//End of $_FILES['photo']['name'][0] not empty
	else{
		header('Location: '.$url."?productId=".$id."?msg=You didn't select any images for upload");
	}
}

?>

