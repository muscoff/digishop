<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/libraries/lib.php";

$sizeArray = array();

$length = array();

$data = json_decode(file_get_contents(url_location.'react/home/product.php'),true);

foreach ($data as $key => $value) {
	$size = $value['sizes'];
	foreach ($size as $key => $sizevalue) {
		array_push($sizeArray, strtoupper($sizevalue['size']));
		array_push($length, $sizevalue['length']);
	}
}

sort($sizeArray);
sort($length);

$uniqueSize = array_unique($sizeArray);
$uniqueLength = array_unique($length);

if(isset($_GET['size'])){
	echo_json($uniqueSize);
}

if(isset($_GET['length'])){
	echo_json($uniqueLength);
}