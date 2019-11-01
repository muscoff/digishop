<?php  

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageTwo.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

//initialize db
$DBH = new DB();
$db = $DBH->connect();

//Initialize Page
$page = new PageTwo($db);

//Get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$first_cap = $_POST['first_cap'];
	$second_cap = $_POST['second_cap'];
	$third_cap = $_POST['third_cap'];
	$first_link = $_POST['first'];
	$second_link = $_POST['second'];

	//Initialize for database
	$page->id = $id;
	$page->first_cap = $first_cap;
	$page->second_cap = $second_cap;
	$page->third_cap = $third_cap;
	$page->first_link = $first_link;
	$page->second_link = $second_link;

	$imageStack = ['image/jpg', 'image/jpeg', 'image/png'];
	$max_size = 2097152;

	if(isset($_FILES['image']['name']) & !empty($_FILES['image']['name'])){
		if($_FILES['image']['size'] <= $max_size){
			if(in_array($_FILES['image']['type'], $imageStack)){
				//Server Location
				$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";
				//DB Location
				$dbLocation = url_location."images/section_one_photos/";

				//Generate Random number
				$rand = rand(1,10000000);

				//Image name
				$imageName = $_FILES['image']['name'];
				//Explode image
				$explodeImage = explode('.', $imageName);
				$imgName = md5($rand.$explodeImage[0]);
				$ext = $explodeImage[1];

				//Server name
				$serverImage = $server.$imgName.'.'.$ext;
				//Db name
				$dbName = $dbLocation.$imgName.'.'.$ext;

				//Initialize image for database
				$page->image = $dbName;

				//temporal Location
				$tmp = $_FILES['image']['tmp_name'];

				//Get old image to remove
				$pageData = $page->fetch();
				$oldImage = $pageData['image'];

				//Explode old image to get the last bit
				$explodeOldImage = explode('/', $oldImage);
				$count = count($explodeOldImage);
				$oldImage = $explodeOldImage[$count-1];

				//move image to server
				if(move_uploaded_file($tmp, $serverImage)){
					if($page->edit()){
						unlink($server.$oldImage);
						$msg = 'Successful update';
						header('Location: '.$url."?msg=".$msg);
					}else{
						unlink($serverImage);
						$msg = 'Failed to update database';
						header('Location: '.$url."?msg=".$msg);
					}
				}else{
					$msg = 'Failed to upload image';
					header('Location: '.$url."?msg=".$msg);
				}
			}else{
				$msg = 'The accepted image format is png, jpeg or jpg';
				header('Location: '.$url."?msg=".$msg);
			}
		}else{
			$msg = 'Please upload an image of 2MB or less';
			header('Location: '.$url."?msg=".$msg);
		}
	}else{
		//Get data for image
		$pageData = $page->fetch();
		$image = $pageData['image'];

		//Initialize image for database
		$page->image = $image;

		if($page->edit()){
			$msg = 'Edited successfully';
			header('Location: '.$url."?msg=".$msg);
		}else{
			$msg = 'Failed to edit';
			header('Location: '.$url."?msg=".$msg);
		}
	}
}

?>