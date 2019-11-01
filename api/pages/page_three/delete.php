<?php  

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageThree.php";

//initialize db
$DBH = new DB();
$db = $DBH->connect();

//Initialize page
$page = new PageThree($db);

//Get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

$id = isset($_GET['id'])?$_GET['id']:die();

//initialize db
$page->id = $id;

if($page->delete()){
	$msg = "Deleted";
	header('Location: '.$url."?msg=".$msg);
}else{
	$msg = "Failed to delete";
	header('Location: '.$url."?msg=".$msg);
}

?>