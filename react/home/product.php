<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$data = json_decode(file_get_contents(url_location.'api/product/fetch.php'), true);

// get category
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);

$content = array();

foreach ($data as $key => $data) {
	$image = $data['image'];

	$imageArray = array();

	$explodeImage = explode(',', $image);

	foreach ($explodeImage as $key => $explodeImage) {
	array_push($imageArray, $explodeImage);
	}

	$parent = null;
	$child = null;

	$pCat = $data['parent_cat'];
	$cCat = $data['child_cat'];

	foreach ($cat as $key => $cate) {
		if($cate['id']==$pCat){
			$parent = $cate['category'];
		}

		if($cate['id'] == $cCat){
			$child = $cate['category'];
		}
	}

	$size = $data['sizes'];
	$sizeArray = array();

	$explodeSize = explode(',', $size);
	foreach ($explodeSize as $key => $sizeValue) {
		// explode to get quantity
		$quantity = explode('-', $sizeValue);
		$q = $quantity[1];

		// explode to get size and length
		$explodeLength = explode(':', $quantity[0]);
		$s = $explodeLength[0]; //this is the size
		$l = $explodeLength[1]; //this is the length

		$arrToPush = array('size'=>$s, 'length'=>$l, 'quantity'=>$q);

		array_push($sizeArray, $arrToPush);
	}

	$category = $child.'-'.$parent;

	$arr = array('id'=>$data['id'], 'title'=>$data['title'], 'price'=>$data['price'], 'brand'=>$data['brand'], 'category'=>$category, 'image'=>$imageArray, 'description'=>$data['description'], 'featured'=>(int)$data['featured'], 'sizes'=>$sizeArray, 'sold'=>$data['sold'], 'created_at'=>$data['created_at'], 'parent'=>(int)$data['parent_cat'], 'child'=>(int)$data['child_cat']);

	array_push($content, $arr);
}

echo json_encode($content);