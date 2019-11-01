<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
$data = json_decode(file_get_contents(url_location.'api/product/fetch.php'),true);

$product = array();

foreach ($data as $data) {
	$id = $data['id'];
	$title = $data['title'];
	$price = $data['price'];
	$brand = $data['brand'];
	$parent_cat = $data['parent_cat'];
	$child_cat = $data['child_cat'];
	$featured = $data['featured'];
	$sizes = $data['sizes'];

	$productImage = $data['image'];
	$explodeImage = explode(',', $productImage);
	$image = $explodeImage[0];
	if($data['featured'] == 1){
		$prouctArray = array('id'=>$id, 'title'=>$title, 'image'=>$image, 'price'=>$price, 'sizes'=>$sizes, 'parent_cat'=>$parent_cat, 'child_cat'=>$child_cat, 'brand'=>$brand, 'featured'=>$featured);
	array_push($product, $prouctArray);
	}
}

echo json_encode($product);


?>