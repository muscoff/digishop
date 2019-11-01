<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageSeven.php";

//Initialize db
$DBH = new DB();
$db = $DBH->connect();

//Initialize page model
$page = new PageSeven($db);

$id = isset($_GET['id'])?$_GET['id']:die();

//initialize id 
$page->id = $id;

//server location
$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";


//Get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

//Get data
$data = $page->fetch();

$image = $data['image'];

//Explode image to get last bit
$explodeImage = explode('/', $image);
$count = count($explodeImage);

$image = $explodeImage[$count-1];

$image = $server.$image;;

if($page->delete()){
	unlink($image);
	$msg = 'Deleted successfully';
	header('Location: '.$url."?msg=".$msg);
}else{
	$msg = 'Failed to delete';
	header('Location: '.$url."?msg=".$msg);
}

?>