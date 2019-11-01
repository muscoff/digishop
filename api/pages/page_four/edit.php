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

if(isset($_POST['id']) & !empty($_POST['id'])){
	$first_link = $_POST['first'];
	$second_link = $_POST['second'];
	$third_link = $_POST['third'];
	$id = $_POST['id'];

	//Initialize for db
	$page->first_link = $first_link;
	$page->second_link = $second_link;
	$page->third_link = $third_link;
	$page->id = $id;

	$imageStack = ["image/png", "image/jpg", "image/jpeg"];
	$max_size = 2097152;

	$imageString = '';

	//Server location
	$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";

	//Db location
	$dbLocation = url_location."images/section_one_photos/";

	if(isset($_FILES['image']['name']) & !empty($_FILES['image']['name'])){
		$count = count($_FILES['image']['name']);
		
		//Name Array, tmp array, server array, db array
		$toDeleteArray = array(); //this array holds the images whoses positions are been replaced by new image(s)
		$tmpArray = array();
		$serverArray = array();
		$dbArray = array();

		//Truth array
		$truth = array();

		//Key position
		$key = array();
		for($i=0; $i<$count; $i++){
			if($_FILES['image']['name'][$i] != ''){
				if($_FILES['image']['size'][$i] <= $max_size){
					if(in_array($_FILES['image']['type'][$i], $imageStack)){
						array_push($key, $i);
					}
				}
			}
		}

		//Count Keys
		$keyCount = count($key);

		for($j = 0; $j<$keyCount; $j++){
			//Generate random number
			$rand = rand(1,1000000);

			//Position
			$pos = $key[$j];

			//Get image name
			$imageName = $_FILES['image']['name'][$pos];

			//Get tmp
			$tmp = $_FILES['image']['tmp_name'][$pos];

			//explode Image
			$explodeImage = explode('.', $imageName);

			//name
			$name = md5($rand.$explodeImage[0]);

			//extension
			$ext = $explodeImage[1];

			//Server Name
			$serverName = $server.$name.'.'.$ext;

			//Db Name
			$dbName = $dbLocation.$name.'.'.$ext;

			//Push to db array
			array_push($dbArray, $dbName);

			//Push to server array
			array_push($serverArray, $serverName);

			//Push to tmp to tmp array
			array_push($tmpArray, $tmp);
		}

		//Count number in db
		$dbCount = count($dbArray);
		for($k = 0; $k<$dbCount; $k++){
			if(move_uploaded_file($tmpArray[$k], $serverArray[$k])){
				array_push($truth, true);
			}else{
				array_push($truth, false);
			}
		}

		if(in_array(false, $truth)){
			foreach ($serverArray as $item) {
				unlink($item);
			}
			$msg = 'Failed to move images successfully';
			header('Location: '.$url."?msg=".$msg);
		}else{
			//Get image name info from db server
			$data = $page->fetch();
			$imageInfo = $data['image'];

			$explodeImageInfo = explode(',', $imageInfo);

			for($m = 0; $m < $keyCount; $m++){
				$position = $key[$m];

				foreach ($explodeImageInfo as $key => $value) {
					if($key == $position){
						$explodeImageInfo[$key] = $dbArray[$m];
						array_push($toDeleteArray, $value);
					}
				}
			}

			foreach ($explodeImageInfo as $newImageString) {
				$imageString = $imageString.$newImageString.',';
			}

			$imageString = rtrim($imageString, ',');

			//initialize for db
			$page->image = $imageString;

			if($page->edit()){
				foreach ($toDeleteArray as $toDelete) {
					$explodeItemToUnlink = explode('/', $toDelete);
					$countExplodeItem = count($explodeItemToUnlink);
					$itemToUnlink = $explodeItemToUnlink[$countExplodeItem-1];
					unlink($server.$itemToUnlink);
				}
				$msg = 'successfully edited';
				header('Location: '.$url."?msg=".$msg);
			}else{
				foreach ($serverArray as $moved) {
					unlink($moved);
				}
				$msg = 'Failed to update database';
				header('Location: '.$url."?msg=".$msg);
			}
		}

	}
	// else{
	// 	echo 'ayoo';
	// }
}

?>