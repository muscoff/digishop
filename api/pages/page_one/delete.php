<?php  

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageOne.php";

$DBH = new DB();
$db = $DBH->connect();

$page = new PageOne($db);

//Get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

$id = isset($_GET['id'])?$_GET['id']:die();

$page->id = $id;

//fetch data
$data = $page->fetch();
$imageName = $data['image'];

$server = $_SERVER['DOCUMENT_ROOT']."/digishop/images/section_one_photos/";

// Explode and get last bit 
$explodeImg = explode('/', $imageName);
$count = count($explodeImg);
$imageName = $explodeImg[$count-1];
$imageName = $server.$imageName;

if($page->delete()){
	unlink($imageName);
	$msg = 'Deleted successfully';
	header('Location: '.$url."?msg=".$msg);
}else{
	$msg = 'Failed to delete';
	header('Location: '.$url."?msg=".$msg);
}

?>