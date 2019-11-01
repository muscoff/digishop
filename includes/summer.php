<?php  
//Get page data
$data = json_decode(file_get_contents(url_location.'api/pages/page_five/fetch.php'),true);

if(!empty($data)){

$firstLink = $data['first_link'];
$secondLink = $data['second_link'];

$firstTitle = null;
$secondTitle = null;

//Get Category
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);
//Parent Array
$parent = array();

foreach ($cat as $cat) {
	if($cat['parent'] == 0){
		$arr = array('id'=>$cat['id'], 'category'=>$cat['category'], 'parent'=>$cat['parent']);
		array_push($parent, $arr);
	}
}

foreach ($parent as $parent) {
	if($parent['id'] == $firstLink){
		$firstTitle = $parent['category'];
	}

	if($parent['id'] == $secondLink){
		$secondTitle = $parent['category'];
	}
}

?>

<!-- summer -->
	<div class="width-100 height-90 height-s-50 height-m-50 banner">
		<img src="<?=$data['image'];?>">
		<div class="full flex-column justify-content-center align-items-center overflow-hidden">
			<div class="white-text word-spacing-0-2 font-25 font-s-12 font-m-20 capitalize italic">
				-<?=$data['first_cap'];?>-
			</div>
			<div class="uppercase white-text font-50 font-s-20 font-m-30 font-allerBd center-text bold-text">
				<div><?=$data['second_cap'];?></div> 
				<div><?=$data['third_cap'];?></div>
			</div>
			<div class="flex-row justify-content-center margin-top-10">
				<div class="uppercase padding-right-10">
					<a href="<?=url_location;?>product.php?cat=<?=$firstLink;?>" class="deep-grey-text">
						<span class="white-bg font-allerBd padding-all-13 padding-s-all-10"><?=$firstTitle;?>'s shorts</span>
					</a>
				</div>
				<div class="uppercase padding-left-10">
					<a href="<?=url_location;?>product.php?cat=<?=$secondLink;?>" class="deep-grey-text">
						<span class="white-bg font-allerBd padding-all-13 padding-s-all-10"><?=$secondTitle;?>'s shorts</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- break -->
	<div class="width-100 height-5"></div>

	<?php } ?>