<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
$data = json_decode(file_get_contents(url_location.'api/product/fetch_ajax.php'),true);

$id = isset($_GET['id'])?$_GET['id']:die();
$id = (int)$id;

$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);

$parentId = array();

foreach ($cat as $cat) {
	if($cat['parent'] == 0){
		array_push($parentId, $cat['id']);
	}
}

$product = array();
$childArray = array();
$child = array();

foreach ($data as $data) {
	if(in_array($data['parent_cat'], $parentId) & $data['parent_cat'] == $id){
		array_push($product, $data);
	}
	else{
		array_push($childArray, $data);
	}
}

foreach ($childArray as $childArray){
	if($childArray['child_cat'] == $id){
		array_push($child, $childArray);
	}
}


if(in_array($id, $parentId)){
	echo json_encode($product);
}else{
	echo json_encode($child);
}


?>