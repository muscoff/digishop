<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";

$data = json_decode(file_get_contents(url_location.'api/pages/page_four/fetch.php'), true);
$images = $data['image'];
$explodeImage = explode(',', $images);

$firstImage = $explodeImage[0];
$secondImage = $explodeImage[1];
$thirdImage = $explodeImage[2];

$firstLink = $data['first_link'];
$secondLink = $data['second_link'];
$thirdLink = $data['third_link'];

$firstTitle = null;
$secondTitle = null;
$thirdTitle = null;

// get category
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);

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

$firstArr = array('title'=>$firstTitle, 'link'=>$firstLink, 'image'=>$firstImage);
$secondArr = array('title'=>$secondTitle, 'link'=>$secondLink, 'image'=>$secondImage);
$thirdArr = array('title'=>$thirdTitle, 'link'=>$thirdLink, 'image'=>$thirdImage);

$contentArray = [$firstArr, $secondArr, $thirdArr];

$arr = array('id'=>$data['id'], 'content'=>$contentArray,'created_at'=>$data['created_at']);

echo json_encode($arr);

?>