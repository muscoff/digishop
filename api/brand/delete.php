<?php  

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Brand.php";

// Database
$DBH = new DB();
$db = $DBH->connect();

// Brand
$brand = new Brand($db);


$url = $_SERVER['HTTP_REFERER'];

$explode = explode('?', $url);

$url = $explode[0];

$id = isset($_GET['delete'])? $_GET['delete']: die();

$brand->id = $id;
	
$msg = $brand->deleteBrand();

header('Location: '.$url."?msg=".$msg['msg']);

?>