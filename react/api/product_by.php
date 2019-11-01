<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/libraries/lib.php";

$content = array();

$data = json_decode(file_get_contents(url_location.'react/home/product.php'),true);

if(isset($_GET['size'])){

foreach ($data as $key => $value) {
	foreach ($value['sizes'] as $key => $size) {
		if(strtolower($size['size']) == strtolower($_GET['size'])){
			array_push($content, $value);
		}
	}
}

	echo_json($content);
}

if(isset($_GET['length'])){

foreach ($data as $key => $value) {
	foreach ($value['sizes'] as $key => $size) {
		if(strtolower($size['length']) == strtolower($_GET['length'])){
			array_push($content, $value);
		}
	}
}

	echo_json($content);
}

if(isset($_GET['price'])){
	$price = $_GET['price'];

	if($price == 100){
		foreach ($data as $key => $value) {
			if($value['price'] >= 100){
				array_push($content, $value);
			}
		}
		echo_json($content);
	}else{
		$price = trim($price);
		$explode = explode('-', $price);
		$first = (int)$explode[0];
		$second = !empty($explode[1])?(int)$explode[1]:((int)$explode[1]*2);

		foreach ($data as $key => $value) {
			if($first < $value['price'] & $second > $value['price'] & $value['featured'] == 1)
			{
				array_push($content, $value);
			}
		}
		echo_json($content);
	}
}