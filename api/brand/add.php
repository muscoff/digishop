<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Brand.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

// Database
$DBH = new DB();
$db = $DBH->connect();

// Brand
$brand = new Brand($db);

$url = $_SERVER['HTTP_REFERER'];

$explode = explode('?', $url);

$url = $explode[0];

// Get admin id and other details
if(isset($_POST['brand']) & !empty($_POST['brand'])){

	// check
	$check = false;

	//check database
	$data = json_decode(file_get_contents(url_location.'api/brand/fetch.php'), true);

	foreach ($data as $value) {
		if(strtolower($value['brand']) == strtolower($_POST['brand'])){
			$check = true;
		}
	}

	if($check){
		header('Location: '.$url."?msg=Already Exist in Database");
	}
	else{
		$brand->brand = $_POST['brand'];
		$msg = $brand->addBrand();

		header('Location: '.$url."?msg=".$msg['msg']);
	}
}

?>