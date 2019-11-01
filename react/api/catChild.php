<?php  
header("Access-Control-Allow-Origin: *");
header("Content-type: Application/json");
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Category.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$id = isset($_GET['id'])?$_GET['id']:die();

$data = json_decode(file_get_contents(url_location.'react/home/category.php'),true);
$child = null;
foreach ($data as $key => $value) {
	if($value['id'] == $id){
		$child = $value['children'];
	}
}

echo json_encode($child);