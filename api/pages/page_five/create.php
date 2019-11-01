<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageFive.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

//Initialize db
$DBH = new DB();
$db = $DBH->connect();

// Initialize Page
$page = new PageFive($db);

//Get Url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

//Get Post Data
if(isset($_POST['first_cap'])){
	$first_cap = $_POST['first_cap'];
	$second_cap = $_POST['second_cap'];
	$third_cap = $_POST['third_cap'];
	$first_link = $_POST['first'];
	$second_link = $_POST['second'];

	//Initialize them for database
	$page->first_cap = $first_cap;
	$page->second_cap = $second_cap;
	$page->third_cap = $third_cap;
	$page->first_link = $first_link;
	$page->second_link = $second_link;

	$imageStack = ["image/png", "image/jpg", "image/jpeg"];
	$max_size = 2097152;

	$imageName = null;
	$tmp = null;
	//Generate Random number
	$rand = rand(1,1000000);

	//Server location and Db location
	$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";
	$dbLocation = url_location.'images/section_one_photos/';

	//Server name and db name
	$serverName = null;
	$dbName = null;

	//Get Image
	if(isset($_FILES['image']['name']) & !empty($_FILES['image']['name'])){
		if($_FILES['image']['size'] <= $max_size){
			if(in_array($_FILES['image']['type'], $imageStack)){
				$image = $_FILES['image']['name'];
				$explodeImage = explode('.', $image);
				$name = md5($rand.$explodeImage[0]);
				$ext = $explodeImage[1];
				$imageName = $name.'.'.$ext;

				//set temp location
				$tmp = $_FILES['image']['tmp_name'];

				//Server and db names
				$serverName = $server.$imageName;
				$dbName = $dbLocation.$imageName;

				//Initialize image for db
				$page->image = $dbName;

				if(move_uploaded_file($tmp, $serverName)){
					if($page->create()){
						$msg = 'success';
						header('Location: '.$url."?msg=".$msg);
					}else{
						unlink($serverName);
						$msg = 'Failed to insert details to database';
						header('Location: '.$url."?msg=".$msg);
					}
				}else{
					$msg = 'Failed to move files to server';
					header('Location: '.$url."?msg=".$msg);
				}
			}else{
				$msg = 'Accepted image formats are png, jpeg or jpg. Thank you';
				header('Location: '.$url."?msg=".$msg);
			}
		}else{
			$msg = 'Please upload an image of size 2MB or less. Thank you';
			header('Location: '.$url."?msg=".$msg);
		}
	}
	else{
		$msg = 'Please make sure to upload an image to proceed. Thank you';
		header('Location: '.$url."?msg=".$msg);
	}

}

?>