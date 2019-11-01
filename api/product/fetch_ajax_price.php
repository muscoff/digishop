<?php  
header('Content-type: Application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
$data = json_decode(file_get_contents(url_location.'api/product/fetch_ajax.php'),true);

//Get size
$price = isset($_GET['price'])?$_GET['price']:die();
$price = trim($price);

//Explode price to get limits
$explodePrice = explode('-', $price);
$first_limit = (int)$explodePrice[0];
$second_limit = !empty($explodePrice[1])?(int)$explodePrice[1]:((int)$first_limit*2);

$product = array();

foreach ($data as $data) {
	$id = $data['id'];
	$title = $data['title'];
	$fetch_price = $data['price'];

	$image = $data['image'];

	if($first_limit<$fetch_price & $fetch_price<$second_limit & $data['featured'] == 1){
		$prouctArray = array('id'=>$id, 'title'=>$title, 'image'=>$image, 'price'=>$fetch_price);
		array_push($product, $prouctArray);
	}
}



echo json_encode($product);

?>