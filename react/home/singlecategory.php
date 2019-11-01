<?php  
header("Access-Control-Allow-Origin: *");
header("Content-type: Application/json");
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Category.php";

$id = isset($_GET['id'])?$_GET['id']:die();

// initialize db
$DBH = new DB();
$db = $DBH->connect();

$category = new Category($db);

$data = $category->getParent();

$result = null;

$arr = array();

foreach ($data as $key => $value) {
	if($value['id'] == $id){
		$result = array('id'=>(int)$value['id'], 'category'=>$value['category'], 'parent'=>(int)$value['parent']);
	}
}

echo json_encode($result);