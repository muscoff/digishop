<?php  
//header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageOne.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";


$DBH = new DB();
$db = $DBH->connect();

//PageOne 
$page = new PageOne($db);

//Get url
$url = $_SERVER['HTTP_REFERER'];

$explode = explode('?', $url);

$url = $explode[0];

if(isset($_POST['first_cap'])){
	$first_cap = $_POST['first_cap'];
	$second_cap = $_POST['second_cap'];
	$first_link = $_POST['first_link'];
	$second_link = $_POST['second_link'];
	$third_link = $_POST['third_link'];

	//prepare for db
	$page->first_cap = $first_cap;
	$page->second_cap = $second_cap;
	$page->first_link = $first_link;
	$page->second_link = $second_link;
	$page->third_link = $third_link;

	$imageStack = ['image/jpg', 'image/jpeg', 'image/png'];
	$max_size = 2097152;

	if(isset($_FILES['image']['name']) & !empty($_FILES['image']['name'])){
		if(in_array($_FILES['image']['type'], $imageStack)){
			if($_FILES['image']['size'] <= $max_size){
				//server root for image when uploading
				$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";

				//db root for image when uploading
				$imgDb = url_location."images/section_one_photos/";

				//get image name
				$image = $_FILES['image']['name'];

				//generate random number between 1 and 1,000,000
				$rand = rand(1,1000000);

				//Explode image to get name and ext
				$explodeImage = explode('.', $image);

				//image name
				$name = md5($rand.$explodeImage[0]);

				//image ext
				$ext = $explodeImage[1];

				//image for db
				$image = $imgDb.$name.'.'.$ext;

				//image for server
				$imgServer = $server.$name.'.'.$ext;

				//initialize image name for db
				$page->image = $image;

				//Temp location
				$tmp = $_FILES['image']['tmp_name'];

				//move file
				if(move_uploaded_file($tmp, $imgServer)){
					if($page->create()){
						$msg = 'Success';
						header('Location: '.$url."?msg=".$msg);
					}else{
						unlink($imgServer);
						$msg = 'Failed insert data in database';
						header('Location: '.$url."?msg=".$msg);
					}
				}else{
					$msg = 'Failed to move image';
					header('Location: '.$url."?msg=".$msg);
				}

				echo $image;
			}else{
				$msg = 'Please make sure the image is not more than 2MB';
				header('Location: '.$url."?msg=".$msg);
			}
		}else{
			$msg = 'Please make sure to upload an image of format type jpg, jpeg or png';
			header('Location: '.$url."?msg=".$msg);
		}
	}else{
		$msg = 'Please upload a nice background image for this section else turn it off for now. Thank you';
		header('Location: '.$url."?msg=".$msg);
	}
}

?>