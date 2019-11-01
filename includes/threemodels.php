<?php  

//Get Data
$data = json_decode(file_get_contents(url_location.'api/pages/page_four/fetch.php'),true);

if(!empty($data)){

$image = $data['image'];

//explode to get the images
$imageExplode = explode(',', $image);

//Get category
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);

//Get parent
$parent = array();

foreach ($cat as $cat) {
	if($cat['parent'] == 0){
		$arr = array('id'=>$cat['id'], 'category'=>$cat['category'], 'parent'=>$cat['parent']);
		array_push($parent, $arr);
	}
}

//Get First, Second and Third Links
$firstLink = $data['first_link'];
$secondLink = $data['second_link'];
$thirdLink = $data['third_link'];

$firstParent = $parent;
$secondParent = $parent;
$thirdParent = $parent;

//DataLink and Title
$dataLink = array();

//Generate Link and Title
foreach ($firstParent as $firstParent) {
	if($firstParent['id']== $firstLink){
		array_push($dataLink, array('title'=>$firstParent['category'], 'link'=>$firstParent['id']));
	}
}

foreach ($secondParent as $secondParent) {
	if($secondParent['id']== $secondLink){
		array_push($dataLink, array('title'=>$secondParent['category'], 'link'=>$secondParent['id']));
	}
}

foreach ($thirdParent as $thirdParent) {
	if($thirdParent['id']== $thirdLink){
		array_push($dataLink, array('title'=>$thirdParent['category'], 'link'=>$thirdParent['id']));
	}
}

//Generate New array for display
$newArray = array();

foreach ($imageExplode as $key => $value) {
	$imageName = $value;
	$title = $dataLink[$key]['title'];
	$link = $dataLink[$key]['link'];
	array_push($newArray, array('image'=>$imageName, 'title'=>$title, 'link'=>$link));
}

//echo json_encode($newArray);

?>

	<!-- three levis models -->
	<div class="">
		<div class="row">
			<?php foreach($newArray as $displayData): ?>
				<div class="col-4 flex-column justify-content-center align-items-center">
					<div class="padding-all-20 padding-s-all-1 padding-m-all-5"> <!-- width-auto height-80 height-s-40 -->
						<div class="img-container-100">
							<img src="<?=$displayData['image'];?>">
						</div>
					</div>
					<div class="padding-all-10 padding-s-all-1 padding-m-all-5"> <!-- height-s-5  -->
						<div class="center-text uppercase font-s-10">
							<a href="<?=url_location;?>product.php?cat=<?=$displayData['link'];?>">
								<span class="border-bottom-3-grey bold-text">shop <?=$displayData['title'];?></span>
							</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>		
		</div>
	</div>

	<!-- break -->
	<div class="width-100 height-5"></div>

	<?php } ?>