<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Category.php";

// Database
$DBH = new DB();
$db = $DBH->connect();

// Category
$category = new Category($db);


$url = $_SERVER['HTTP_REFERER'];

$explode = explode('?', $url);

$url = $explode[0];

if(isset($_POST['parent']) & !empty($_POST['parent'])){
	$id = $_POST['id'];
	$parent = $_POST['parent'];
	$cat = $_POST['category'];

	$category->id = $id;
	$category->category = $cat;
	$category->parent = $parent;

	$msg = $category->edit();

	header('Location: '.$url."?msg=".$msg['msg']);
}
?>