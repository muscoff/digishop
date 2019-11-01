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

if(isset($_POST['brand']) & !empty($_POST['brand'])){
	$id = $_POST['id'];
	$name = $_POST['brand'];

	$brand->id = $id;
	$brand->brand = $name;

	$msg = $brand->editBrand();

	header('Location: '.$url."?msg=".$msg['msg']);
}

?>