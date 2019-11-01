<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Category.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

// Database
$DBH = new DB();
$db = $DBH->connect();

// Category
$category = new Category($db);

// Get url
$url = $_SERVER['HTTP_REFERER'];

$explode = explode('?', $url);

$url = $explode[0];


if(isset($_POST['parent'])){
	// check
	$check = false;

	//check database
	$data = json_decode(file_get_contents(url_location.'api/category/fetch.php'), true);

	foreach ($data as $value) {
		if(strtolower($value['category']) == strtolower($_POST['category'])){
			$check = true;
		}
	}

	if($check){
		header('Location: '.$url."?msg=Already Exist in Database");
	}
	else{
		$category->category = $_POST['category'];
		$category->parent = $_POST['parent'];
		$msg = $category->add();

		header('Location: '.$url."?msg=".$msg['msg']);
	}
}
?>