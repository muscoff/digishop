<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Control.php";

$id = isset($_GET['id'])?$_GET['id']:die();
$fifth = isset($_GET['fifth'])?$_GET['fifth']:die();

// Initialize db
$DBH = new DB();
$db = $DBH->connect();

// Initialize control
$control = new Control($db);

//Get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

//Initialize id and first_sec
$control->id = $id;
$control->fifth_sec = $fifth;

if($control->update_five()){
	header('Location: '.$url);
}else{
	$msg = 'Failed to update section one';
	header('Location: '.$url."?msg=".$msg);
}

?>