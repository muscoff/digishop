<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$data = json_decode(file_get_contents(url_location.'api/pages/page_five/fetch.php'), true);

$firstTitle = null;
$secondTitle = null;

$firstLink = $data['first_link'];
$secondLink = $data['second_link'];

// get cat
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);

foreach ($cat as $key => $cat) {
	if($cat['id'] == $firstLink){
		$firstTitle = $cat['category'];
	}

	if($cat['id'] == $secondLink){
		$secondTitle = $cat['category'];
	}
}

$arr = array('id'=>$data['id'], 'image'=>$data['image'], 'first_link'=>$firstLink, 'second_link'=>$secondLink, 'firstTitle'=>$firstTitle, 'secondTitle'=>$secondTitle, 'first_cap'=>$data['first_cap'], 'second_cap'=>$data['second_cap'], 'third_cap'=>$data['third_cap']);

echo json_encode($arr);

?>