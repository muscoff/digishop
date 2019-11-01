<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Control.php";

$id = isset($_GET['id'])?$_GET['id']:die();
$sixth = isset($_GET['sixth'])?$_GET['sixth']:die();

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
$control->sixth_sec = $sixth;

if($control->update_six()){
	header('Location: '.$url);
}else{
	$msg = 'Failed to update section one';
	header('Location: '.$url."?msg=".$msg);
}

?>