<?php  
//header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageOne.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";


$DBH = new DB();
$db = $DBH->connect();

$page = new PageOne($db);

// Get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);

$url = $explode[0];

if(isset($_POST['first_cap'])){
	// Get post data
	$id = $_POST['id'];
	$first_cap = $_POST['first_cap'];
	$second_cap = $_POST['second_cap'];
	$first_link = $_POST['first_link'];
	$second_link = $_POST['second_link'];
	$third_link = $_POST['third_link'];

	// Prepare data for database
	$page->id = $id;
	$page->first_cap = $first_cap;
	$page->second_cap = $second_cap;
	$page->first_link = $first_link;
	$page->second_link = $second_link;
	$page->third_link = $third_link;

	$imageStack = ['image/jpg', 'image/jpeg', 'image/png'];
	$max_size = 2097152;

	if(isset($_FILES['image']['name']) & !empty($_FILES['image']['name'])){
		if($_FILES['image']['size'] <= $max_size){
			if(in_array($_FILES['image']['type'], $imageStack)){
				// Server location
				$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";

				// Db Location
				$dblocation = url_location.'images/section_one_photos/';

				//Fetch Data to compare
				$data = $page->fetch();

				// Get image name old image
				$imageName = $data['image'];

				// Explode image name to get the ending bit
				$explodeImageName = explode('/', $imageName);

				$count = count($explodeImageName);

				$imageName = $explodeImageName[$count-1];

				$imageName = $server.$imageName; // old pic to unlink from database because we are uploading new one

				// Generate random number
				$rand = rand(1, 1000000);

				$newImageName = $_FILES['image']['name'];

				//Temp Location
				$tmp = $_FILES['image']['tmp_name'];

				$imgExplode = explode('.', $newImageName);

				$img_name = md5($rand.$imgExplode[0]);

				$ext = $imgExplode[1];

				$newImageName =  $img_name.'.'.$ext;

				//server name
				$serverName = $server.$newImageName; // what to upload by server

				//$db name
				$dbName = $dblocation.$newImageName; // db location

				//Syn with db
				$page->image = $dbName;

				if(move_uploaded_file($tmp, $serverName)){
					if($page->edit()){
						unlink($imageName);
						$msg = 'Update has been successful';
						header('Location: '.$url."?msg=".$msg);
					}else{
						unlink($serverName);
						$msg = 'Failed to update database';
						header('Location: '.$url."?msg=".$msg);
					}
				}else{
					$msg = 'Failed to upload pic';
					header('Location: '.$url."?msg=".$msg);
				}
			}//End of image format .. Whether image/png, image/jpeg or image/jpg
			else{
				$msg = 'Please upload the right kind of image format. Accepted format are jpg, jpeg or png';
				header('Location: '.$url."?msg=".$msg);
			}
		}//End of image size. Only 2MB or less are accepted
		else{
			$msg = 'Please make sure to upload an image 2MB or less';
			header('Location: '.$url."?msg=".$msg);
		}
	}else{
		//Fetch Data to compare
		$data = $page->fetch();

		// Get image name
		$imageName = $data['image'];

		//Prepare image for database
		$page->image = $imageName;

		if($page->edit()){
			$msg = 'Edit has been successful';
			header('Location: '.$url."?msg=".$msg);
		}else{
			$msg = 'Edit failed';
			header('Location: '.$url."?msg=".$msg);
		}
	}
}

?>