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

if(isset($_POST['id'])){
	$id = sanitize_text($_POST['id']);
	$image = null;
	if(isset($_FILES['image'])){
		//single_image fxn accepts three params $_FILES[name], db, server.. By default, db and server is set to null
		$db = url_location.'images/section_one_photos';
		$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos";
		$image = single_image($_FILES['image'], $db, $server);
	}else{
		echo json_encode(array('msg'=>'pussy'));
	}
	$data = $control->fetch();
	$logo = $data['logo'];
	$explode = explode('/', $logo);
	$logo = end($explode);
	$logo = $server.'/'.$logo;
	if(!is_null($image)){
		if(is_array($image)){
			$control->logo = $image['db_location'];
			$control->id = $id;
			$tmp = $image['tmp'];
			$final = $image['server_location'];

			$truth = move_file($tmp, $final);
			if(in_array(false, $truth)){
				echo_json(array('failed to move file to server'));
			}else{
				if($control->update_logo()){
					unlink($logo);
					echo_json(array('msg'=>'update was successful'));
				}else{
					unlink($image['server_location']);
					echo_json(array('msg'=>'failed to update'));
				}
			}
		}else{
		echo_json(array('msg'=>'Image size should be 2MB or less. Please make sure to upload an image.'));
		}
	}else{
		echo_json(array('msg'=>'Image size should be 2MB or less. Please make sure to upload an image.'));
	}
}