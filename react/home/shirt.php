<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$data = json_decode(file_get_contents(url_location.'api/pages/page_six/fetch.php'), true);

$firstTitle = null;
$secondTitle = null;
$thirdTitle = null;

$firstLink = $data['first_link'];
$secondLink = $data['second_link'];
$thirdLink = $data['third_link'];

// get category
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'), true);

foreach ($cat as $key => $cat) {
	if($cat['id'] == $firstLink){
		$firstTitle = $cat['category'];
	}

	if($cat['id'] == $secondLink){
		$secondTitle = $cat['category'];
	}

	if($cat['id'] == $thirdLink){
		$thirdTitle = $cat['category'];
	}

}

$arr = array('id'=>$data['id'], 'first_cap'=>$data['first_cap'], 'second_cap'=>$data['second_cap'], 'first_title'=>$firstTitle, 'first_link'=>$firstLink, 'second_title'=>$secondTitle, 'second_link'=>$secondLink, 'third_title'=>$thirdTitle, 'third_link'=>$thirdLink, 'image'=>$data['image'] ,'created_at'=>$data['created_at']);

echo json_encode($arr);

?>