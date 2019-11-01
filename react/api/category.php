<?php  
header("Access-Control-Allow-Origin: *");
//header("Content-type: Application/json");
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Category.php";

// initialize db
$DBH = new DB();
$db = $DBH->connect();

$category = new Category($db);

if(isset($_POST['category']) & isset($_POST['parent']) & isset($_POST['id'])){
	$categoryString = $_POST['category'];
	$parent = $_POST['parent'];
	$id = $_POST['id'];

	$category->category = $categoryString;
	$category->parent = $parent;
	$category->id = $id;

	$msg = $category->edit();

	echo json_encode($msg);
}
elseif(isset($_POST['category']) & isset($_POST['parent'])){
	$categoryString = $_POST['category'];
	$parent = $_POST['parent'];

	// initialize value for db
	$category->category = $categoryString;
	$category->parent = $parent;

	$msg = $category->add();

	echo json_encode($msg);
}

if(isset($_GET['id'])){
	$id = $_GET['id'];

	$category->id = $id;

	$msg = $category->delete();

	echo json_encode($msg);
}