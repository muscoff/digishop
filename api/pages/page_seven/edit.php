<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageSeven.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

//Initialize db
$DBH = new DB();
$db = $DBH->connect();

//Initialize page model
$page = new PageSeven($db);

//Get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

if(isset($_POST['first_cap'])){
	$first_cap = $_POST['first_cap'];
	$second_cap = $_POST['second_cap'];
	$third_cap = $_POST['third_cap'];
	$page_link = $_POST['page_link'];
	$id = $_POST['id'];

	//Initialize for db
	$page->first_cap = $first_cap;
	$page->second_cap = $second_cap;
	$page->third_cap = $third_cap;
	$page->page_link = $page_link;
	$page->id = $id;

	//server
	$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";

	//db location
	$dbLocation = url_location."images/section_one_photos/";

	//Image name
	$imageName = null;

	//Server name and DB name
	$serverName = null;
	$dbName = null;

	//Temporal location
	$tmp = null;

	//Generate Random number
	$rand = rand(1,1000000);

	//max size and type
	$imageStack = ["image/png", "image/jpg", "image/jpeg"];
	$max_size = 2097152;

	if(isset($_FILES['image']['name']) & !empty($_FILES['image']['name'])){
		if($_FILES['image']['size'] <= $max_size){
			if(in_array($_FILES['image']['type'], $imageStack)){
				$imageName = $_FILES['image']['name'];
				$explodeImage = explode('.', $imageName);
				$imageName = md5($rand.$explodeImage[0]);
				$ext = $explodeImage[1];
				$imageName = $imageName.'.'.$ext;

				//set tmp
				$tmp = $_FILES['image']['tmp_name'];

				//set db and server name
				$dbName = $dbLocation.$imageName;
				$serverName = $server.$imageName;

				//initialize image for db
				$page->image = $dbName;

				//Fetch old image to remove
				$data = $page->fetch();
				$oldImage = $data['image'];
				$explodeOldImage = explode('/', $oldImage);
				$count = count($explodeOldImage);
				$oldImage = $explodeOldImage[$count-1];

				if(move_uploaded_file($tmp, $serverName)){
					if($page->edit()){
						unlink($server.$oldImage);
						$msg = 'Edited successfully';
						header('Location: '.$url."?msg=".$msg);
					}else{
						unlink($serverName);
						$msg = 'Failed to insert details in database';
						header('Location: '.$url."?msg=".$msg);
					}
				}else{
					$msg = 'Failed to move image to server';
					header('Location: '.$url."?msg=".$msg);
				}
			}else{
				$msg = 'Accepted image format should be png, jpeg or jpg';
				header('Location: '.$url."?msg=".$msg);
			}
		}else{
			$msg = 'Accepted image size should be 2MB or less. Thank you';
			header('Location: '.$url."?msg=".$msg);
		}
	}else{
		//Get image data
		$data = $page->fetch();
		$imageName = $data['image'];

		//Initialize image for db
		$page->image = $imageName;

		if($page->edit()){
			$msg = 'Successfully edited';
			header('Location: '.$url."?msg=".$msg);
		}else{
			$msg = 'Failed to edit';
			header('Location: '.$url."?msg=".$msg);
		}
	}

}

?>