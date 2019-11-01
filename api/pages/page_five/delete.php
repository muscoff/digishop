<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageFive.php";

//Initialize db
$DBH = new DB();
$db = $DBH->connect();

// Initialize Page
$page = new PageFive($db);

//Get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

// Get id
$id = isset($_GET['id'])?$_GET['id']:die();

//initialize id 
$page->id = $id;

//Get image to delete
$data = $page->fetch();
$image = $data['image'];

$explodeImage = explode('/', $image);
$count = count($explodeImage);
$image =$explodeImage[$count-1];

//server Location
$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";

if($page->delete()){
	unlink($server.$image);
	$msg = 'Successfully deleted';
	header('Location: '.$url."?msg=".$msg);
}else{
	$msg = 'Failed to delete';
	header('Location: '.$url."?msg=".$msg);
}

?>