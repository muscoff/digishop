<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Control.php";

$id = isset($_GET['id'])?$_GET['id']:die();
$first = isset($_GET['first'])?$_GET['first']:die();

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
$control->first_sec = $first;

if($control->update_one()){
	header('Location: '.$url);
}else{
	$msg = 'Failed to update section one';
	header('Location: '.$url."?msg=".$msg);
}

?>