<?php  
header("Access-Control-Allow-Origin: *");
//header("Content-type: Application/json");
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Brand.php";

// initialize db
$DBH = new DB();
$db = $DBH->connect();

$brand = new Brand($db);

if(isset($_POST['brand']) & isset($_POST['id'])){
	$brandString = $_POST['brand'];

	$brand->brand = $brandString;
	$brand->id = $_POST['id'];

	$msg = $brand->EditBrand();

	echo json_encode($msg);
}
elseif(isset($_POST['brand'])){
	$brandString = $_POST['brand'];

	$brand->brand = $brandString;

	$msg = $brand->addBrand();

	echo json_encode($msg);
}

if(isset($_GET['id'])){
	$deleteId = $_GET['id'];

	$brand->id = $deleteId;

	$msg = $brand->deleteBrand();

	echo json_encode($msg);
}