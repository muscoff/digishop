<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageFour.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

//Initialize db
$DBH = new DB();
$db = $DBH->connect();

//Initialize page
$page = new PageFour($db);

//Get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

if(isset($_POST['first'])){
	$first_link = $_POST['first'];
	$second_link = $_POST['second'];
	$third_link = $_POST['third'];

	//Initialize for db
	$page->first_link = $first_link;
	$page->second_link = $second_link;
	$page->third_link = $third_link;

	$imageStack = ["image/png", "image/jpg", "image/jpeg"];
	$max_size = 2097152;

	$imageString = '';

	//Temporal location array
	$tmpArray = array();

	//DB and Server for upload
	$dbArray = array();
	$serverArray = array();

	//Truth array
	$truth = array();

	$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";
	$dbLocation = img_folder."section_one_photos/";

	if(isset($_FILES['image']['name']) & !empty($_FILES['image']['name'][0])){
		$count = count($_FILES['image']['name']);
		for($i = 0; $i<$count; $i++){
			if($_FILES['image']['name'][$i] == ''){
				$msg = 'Please make sure to upload all three images. Thank you';
				header('Location: '.$url."?msg=".$msg);
			}else{
				if($_FILES['image']['size'][$i] <= $max_size){
					if(in_array($_FILES['image']['type'][$i], $imageStack)){
						//Generate random number
						$rand = rand(1,1000000);

						//Get image name
						$imageName = $_FILES['image']['name'][$i];
						$explodeImage = explode('.', $imageName);
						$ext = $explodeImage[1];
						$imageName = md5($rand.$explodeImage[0]);
						$imageName = $imageName.'.'.$ext;

						$dbName = $dbLocation.$imageName;
						$serverName = $server.$imageName;
						array_push($dbArray, $dbName);
						array_push($serverArray, $serverName);
						array_push($tmpArray, $_FILES['image']['tmp_name'][$i]);
					}else{
						$msg = 'Accepted image format is either png, jpeg, or jpg. Thank you';
						header('Location: '.$url."?msg=".$msg);
					}
				}else{
					$msg = 'Accepted image size is 2MB or less. Thank you';
					header('Location: '.$url."?msg=".$msg);
				}
			}
		}

		$countDb = count($dbArray);
		if($countDb !=0){
			foreach ($dbArray as $dbimage) {
				$imageString = $imageString.$dbimage.',';
			}
		}

		//Trim to remove ',' at the last end
		$imageString = rtrim($imageString, ',');
		

		//initialize for db
		$page->image = $imageString;

		//for each image successfully moved, push true into truth array else push false
		for($j = 0; $j<$countDb; $j++){
			if(move_uploaded_file($tmpArray[$j], $serverArray[$j])){
				array_push($truth, true);
			}else{
				array_push($truth, false);
			}
		}

		//check if truth array does not contain false value
		if(in_array(false, $truth)){
			//if false exist in truth array, unlink images uploaded to server
			foreach ($serverArray as $serverItem) {
				unlink($serverItem);
				$msg = 'Failed to upload to server';
				header('Location: '.$url."?msg=".$msg);
			}
		}else{
			if($page->create()){
				$msg = 'Success';
				header('Location: '.$url."?msg=".$msg);
			}else{
				foreach ($serverArray as $sItem) {
					unlink($sItem);
				}
				
				$msg = 'Failed to insert data in database';
				header('Location: '.$url."?msg=".$msg);
			}
		}
	}else{
		$msg = 'Please upload images to continue. Thank you';
		header('Location: '.$url."?msg=".$msg);
	}
}

?>