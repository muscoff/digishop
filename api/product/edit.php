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

if(isset($_POST['title']) & !empty($_POST['title'])){
	$id = $_POST['productId'];
	$title = $_POST['title'];
	$brand = $_POST['brand'];
	$price = $_POST['price'];
	$parent_cat = $_POST['parent_cat'];
	$child_cat = $_POST['child_cat'];
	$sizes = rtrim($_POST['size'], ',');
	$description = $_POST['description'];

	//echo json_encode(array('id'=>$id, 'title'=>$title, 'brand'=>$brand, 'price'=>$price, 'parent_cat'=>$parent_cat, 'child_cat'=>$child_cat, 'sizes'=>$sizes, 'description'=> $description, 'admin_id'=>$admin_id));

	$product->id = $id;
	$product->title = $title;
	$product->brand = $brand;
	$product->price = $price;
	$product->parent_cat = $parent_cat;
	$product->child_cat = $child_cat;
	$product->description = $description;
	$product->sizes = $sizes;

	if($product->edit()){
		header('Location: '.$url.'?msg='.$title.' has been edited successfully');
	}else{
		header('Location: '.$url.'?msg=Failed to update '.$title);
	}

	// header('Location: '.$url."?msg=".$msg['msg']);
}

?>