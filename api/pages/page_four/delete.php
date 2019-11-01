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

$id = isset($_GET['id'])?$_GET['id']:die();

//initialize id
$page->id = $id;

//Server Location
$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";

//Fetch Image Locations
$data = json_decode(file_get_contents(url_location.'api/pages/page_four/fetch.php'),true);

$image = $data['image'];

$explodeImage = explode(',', $image); 

//Explode to get the last bit
$deleteArray = array();

foreach ($explodeImage as $item) {
	$deleteItem = explode('/', $item);
	$count = count($deleteItem);
	$delete_item = $deleteItem[$count-1];
	array_push($deleteArray, $delete_item);
}

//Delete
if($page->delete()){
	foreach ($deleteArray as $value) {
		unlink($server.$value);
	}
	$msg = 'ITEMS DELETED';
	header('Location: '.$url."?msg=".$msg);
}else{
	$msg = 'Failed to delete';
	header('Location: '.$url."?msg=".$msg);
}

?>