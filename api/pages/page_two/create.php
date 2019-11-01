<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageTwo.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

//Initialize db class
$DBH = new DB();
$db = $DBH->connect();

//Initialize Page class
$page = new PageTwo($db);

//Get url
$url = $_SERVER['HTTP_REFERER'];

$explode = explode('?', $url);

$url = $explode[0];

if(isset($_POST['first_cap'])){
	$first_cap = $_POST['first_cap'];
	$second_cap = $_POST['second_cap'];
	$third_cap = $_POST['third_cap'];
	$first_link = $_POST['first'];
	$second_link = $_POST['second'];

	//Initialize for db
	$page->first_cap = $first_cap;
	$page->second_cap = $second_cap;
	$page->third_cap = $third_cap;
	$page->first_link = $first_link;
	$page->second_link = $second_link;

	$imageStack = ["image/png", "image/jpg", "image/jpeg"];
	$max_size = 2097152;

	if(isset($_FILES['image']['name']) & !empty($_FILES['image']['name'])){
		if($_FILES['image']['size'] <= $max_size){
			if(in_array($_FILES['image']['type'], $imageStack)){
				//Server Location
				$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";
				//DB location
				$dbLocation = url_location."images/section_one_photos/";

				//Generate Random number
				$rand = rand(1,1000000);

				//Get image name
				$imageName = $_FILES['image']['name'];
				//Explode and get name and extension
				$imageExplode = explode('.', $imageName);
				$imgName = md5($rand.$imageExplode[0]);
				$ext = $imageExplode[1];
				$imageName = $imgName.'.'.$ext; // name of image now

				//server name for image
				$serverImg = $server.$imageName;

				//db name for image
				$dbName = $dbLocation.$imageName;

				$page->image = $dbName; // initialize image for database

				//temporal location
				$tmp = $_FILES['image']['tmp_name'];

				if(move_uploaded_file($tmp, $serverImg)){
					if($page->create()){
						$msg = 'Success';
						header('Location: '.$url."?msg=".$msg);
					}else{
						unlink($serverImg);
						$msg = 'Failed to insert details in database';
						header('Location: '.$url."?msg=".$msg);
					}
				}else{
					$msg = 'Failed to move image';
					header('Location: '.$url."?msg=".$msg);
				}
			}else{
				$msg = 'Please make sure the image format is either png, jpg or jpeg';
				header('Location: '.$url."?msg=".$msg);
			}
		}else{
			$msg = 'Please make sure the image is 2MB or less. Thank you';
			header('Location: '.$url."?msg=".$msg);
		}
	}else{
		$msg = 'Please upload a background image to make your webpage look great, else turn this section off in the page control section. Thank you';
		header('Location: '.$url.'?msg='.$msg);
	}
}

?>