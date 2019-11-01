<?php  

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageThree.php";

//initialize db
$DBH = new DB();
$db = $DBH->connect();

//Initialize page
$page = new PageThree($db);

//Get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

if(isset($_POST['first_cap'])){
	$first_cap = $_POST['first_cap'];
	$second_cap = $_POST['second_cap'];
	$first_link = $_POST['first'];
	$second_link = $_POST['second'];
	$id = $_POST['id'];

	//initialize for db
	$page->id = $id;
	$page->first_cap = $first_cap;
	$page->second_cap = $second_cap;
	$page->first_link = $first_link;
	$page->second_link = $second_link;

	if($page->edit()){
		$msg = 'Edit has been successful';
		header('Location: '.$url."?msg=".$msg);
	}else{
		$msg = 'Failed to edit';
		header('Location: '.$url."?msg=".$msg);
	}
}

?>