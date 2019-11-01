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

$id = isset($_GET['delete'])? $_GET['delete']: die();

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
	$image = explode('/',$img);
	$count = count($image);
	array_push($imgName, $image[$count-1]);
}
	
if($product->delete()){
	foreach ($imgName as $imgLocal) {
		$imgLocation = $_SERVER['DOCUMENT_ROOT']."/digishop/images/product/".$imgLocal;
		unlink($imgLocation);
	}
	header('Location: '.$url."?msg=Product deleted");
}else{
	header('Location: '.$url."?msg=Failed to delete product");
}

?>