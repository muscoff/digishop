<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Control.php";

$id = isset($_GET['id'])?$_GET['id']:die();
$fourth = isset($_GET['fourth'])?$_GET['fourth']:die();

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
$control->fourth_sec = $fourth;

if($control->update_four()){
	header('Location: '.$url);
}else{
	$msg = 'Failed to update section one';
	header('Location: '.$url."?msg=".$msg);
}

?>