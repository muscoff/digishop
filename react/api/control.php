<?php  
header("Access-Control-Allow-Origin: *");
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Control.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/libraries/lib.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

// initialize db
$DBH = new DB();
$db = $DBH->connect();

$control = new Control($db);

if(isset($_POST)){
	$image = null;
	if(isset($_FILES['image'])){
		//single_image fxn accepts three params $_FILES[name], db, server.. By default, db and server is set to null
		$db = url_location.'images/section_one_photos';
		$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos";
		$image = single_image($_FILES['image'], $db, $server);
	}

	if(!is_null($image)){
		if(is_array($image)){
			$control->logo = $image['db_location'];
			$tmp = $image['tmp'];
			$final = $image['server_location'];

			$truth = move_file($tmp, $final);
			if(in_array(false, $truth)){
				echo_json(array('msg'=>'Upload failed'));
			}else{
				if($control->create()){
					echo_json(array('msg'=>'Logo upload was a success'));
				}else{
					unlink($image['server_location']);
					echo_json(array('msg'=>'Logo upload failed'));
				}
			}
		}else{
		echo_json(array('msg'=>'Image size should be 2MB or less. Please make sure to upload an image.'));
		}
	}else{
		echo_json(array('msg'=>'Image size should be 2MB or less. Please make sure to upload an image.'));
	}
}