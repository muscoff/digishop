<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Control.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

// Initialize db
$DBH = new DB();
$db = $DBH->connect();

// Initialize control
$control = new Control($db);

//Get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

$imageStack = ["image/png", "image/jpg", "image/jpeg"];
$extType = ['png', 'jpeg', 'jpg', 'gif'];
$max_size = 2097152;

$serverName = null;
$dbName = null;

$tmp = null;

if(isset($_POST)){
	$id = $_POST['id'];
	//Initialize id for db
	$control->id = $id;
	
	if(isset($_FILES['image']['name']) & !empty($_FILES['image']['name'])){
		if($_FILES['image']['size'] <= $max_size){
			if(in_array($_FILES['image']['type'], $imageStack)){
				// Db and server locations
				$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";
				$dbLocation = url_location.'images/section_one_photos/';

				// Generate random number
				$rand = rand(1, 10000000);

				$image = $_FILES['image']['name'];
				$explodeImage = explode('.', $image);
				$imageName = md5($rand.$explodeImage[0]); // Image Name
				$ext = $explodeImage[1]; //extension
				
				//check if ext is png, jpeg or jpg
				if(in_array($ext, $extType)){
					$imageName = $imageName.'.'.$ext;

					// Server name and db name
					$serverName = $server.$imageName;
					$dbName = $dbLocation.$imageName;
					
					// Initialize logo name for db
					$control->logo = $dbName;

					$tmp = $_FILES['image']['tmp_name'];


					// Get old logo to remove
					$fetch = $control->fetch();
					$fetchLogo = $fetch['logo'];

					// Explode to get the last bit which contain the logo name
					$explodeLogo = explode('/', $fetchLogo);
					$count = count($explodeLogo);
					$logoName = $explodeLogo[$count-1];

					// Logo to remove
					$logoToRemove = $server.$logoName;

					if(move_uploaded_file($tmp, $serverName)){
						if($control->update_logo()){
							unlink($logoToRemove);
							$msg = 'Logo changed!';
							header('Location: '.$url."?msg=".$msg);
						}else{
							unlink($serverName);
							$msg = 'Failed to update details in database';
							header('Location: '.$url."?msg=".$msg);
						}
					}else{
						$msg = 'Failed to move files to server';
						header('Location: '.$url."?msg=".$msg);
					}
				}else{
					die('...wrong ext type...');
				}
			}else{
				$msg = 'Accepted image format are png, jpeg or jpg. Thank you!';
				header('Location: '.$url."?msg=".$msg);
			}
		}else{
			$msg = 'Please upload an image of 2MB or less. Thank you!';
			header('Location: '.$url."?msg=".$msg);
		}
	}else{
		$msg = 'Please upload your new logo to replace your old logo. Thank you!';
		header('Location: '.$url."?msg=".$msg);
	}
}
?>