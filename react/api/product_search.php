<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/libraries/lib.php";

$catParentId = array();
$catChildId = array();

$content = array();

//get categorys
$cat = json_decode(file_get_contents(url_location.'react/home/category.php'),true);

foreach ($cat as $key => $catvalue) {
	array_push($catParentId, $catvalue['id']);
	foreach ($catvalue['children'] as $key => $child) {
		array_push($catChildId, $child['id']);
	}
}

$product = json_decode(file_get_contents(url_location.'react/home/product.php'),true);

if(isset($_GET['cat'])){
	$catId = sanitize_text($_GET['cat']);

	if(in_array($catId, $catParentId)){
		foreach ($product as $key => $prod) {
			if($prod['parent'] == $catId){
				array_push($content, $prod);
			}
		}
		echo_json($content);
	}elseif(in_array($catId, $catChildId)){
		foreach ($product as $key => $prod) {
			if($prod['child'] == $catId){
				array_push($content, $prod);
			}
		}
		echo_json($content);
	}
}

if(isset($_GET['search'])){
	$search = sanitize_text($_GET['search']);
	$search = strtolower($search);

	foreach ($product as $key => $prod) {
		if(strtolower($prod['title']) == $search){
			array_push($content, $prod);
		}
	}
	echo_json($content);
}