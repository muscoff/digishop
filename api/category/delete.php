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

$id = isset($_GET['delete'])? $_GET['delete']: die();

$category->id = $id;
	
$msg = $category->delete();

header('Location: '.$url."?msg=".$msg['msg']);

?>