<?php  

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Product.php";

// Database
$DBH = new DB();
$db = $DBH->connect();

// Product
$product = new Product($db);


$url = $_SERVER['HTTP_REFERER'];

$explode = explode('?', $url);

$url = $explode[0];

$id = isset($_GET['productId'])? $_GET['productId'] : die();
$imageName = isset($_GET['imgName'])? $_GET['imgName'] : die();

$product->id = $id;

//Get image location
$data = $product->fetch_single();

$imageLocation = $data['image'];

$explodeImage = explode(',', $imageLocation);

// Get the first index and put it in a new array
$arr = array();
foreach($explodeImage as $explodedimg){
	array_push($arr, $explodedimg);
}

$imageLocation = $arr;

$imgName = array();

foreach ($imageLocation as $img) {
	if($img != $imageName){
		array_push($imgName, $img);
	}
}

$imgDbName = '';

foreach ($imgName as $value) {
	$imgDbName = $imgDbName.$value.',';
}

$imgDbName = rtrim($imgDbName,',');

$product->image = $imgDbName; //db update image name

//Explode image and get it ready to be deleted
$imgExplode = explode('/', $imageName);
$count = count($imgExplode);

$imageName = $imgExplode[$count-1];

$imgToUnlink = $_SERVER['DOCUMENT_ROOT']."/digishop/images/product/".$imageName;

if($product->delete_single_image()){
	unlink($imgToUnlink);
	header('Location: '.$url."?productId=".$id);
}

?>