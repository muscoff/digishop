<?php  

//Get Page Data
$data = json_decode(file_get_contents(url_location.'api/pages/page_six/fetch.php'),true);

if(!empty($data)){

//Get category
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);
//Parent Array
$parent = array();

foreach ($cat as $cat) {
	if($cat['parent'] == 0){
		$arr = array('id'=>$cat['id'], 'category'=>$cat['category'], 'parent'=>$cat['parent']);
		array_push($parent, $arr);
	}
}

$firstLink = $data['first_link'];
$secondLink = $data['second_link'];
$thirdLink = $data['third_link'];

//Title
$firstTitle = null;
$secondTitle = null;
$thirdTitle = null;

foreach ($parent as $parent) {
	if($parent['id'] == $firstLink){
		$firstTitle = $parent['category'];
	}

	if($parent['id'] == $secondLink){
		$secondTitle = $parent['category'];
	}

	if($parent['id'] == $thirdLink){
		$thirdTitle = $parent['category'];
	}
}

?>

<!-- shirt woman -->
	<div class="width-100 height-100 height-s-50 height-m-50 banner overflow-hidden">
		<img src="<?=$data['image'];?>">
		<div class="row">
			<div class="col-3 col-s-2 col-m-2"></div>
			<div class="col-2 col-s-6 col-m-4 height-100 height-s-50 height-m-50">
				<div class="full flex-column justify-content-center align-items-center">
					<div class="center-text"> <!-- width-80 width-s-100 margin-auto -->
						<div class="uppercase font-60 font-s-20 font-m-30 font-allerBd center-text bold-text deep-grey-text">
							<?=$data['first_cap'];?>
						</div>
						<div class="center-text font-s-15"><?=$data['second_cap'];?></div>
						<p class="margin-top-10 font-s-12">
							<a href="<?=url_location;?>product.php?cat=<?=$firstLink;?>">
								<span class="border-bottom-3-grey uppercase font-allerBd"><?=$firstTitle;?>'s tees</span>
							</a>
						</p>
						<p class="margin-top-10 font-s-12">
							<a href="<?=url_location;?>product.php?cat=<?=$secondLink;?>">
								<span class="border-bottom-3-grey uppercase font-allerBd"><?=$secondTitle;?>'s tops</span>
							</a>
						</p>
						<p class="margin-top-10 font-s-12">
							<a href="<?=url_location;?>product.php?cat=<?=$thirdLink;?>">
								<span class="border-bottom-3-grey uppercase font-allerBd"><?=$thirdTitle;?> top</span>
							</a>
						</p>
					</div>
				</div>
			</div>
			<div class="col-7 col-s-4 col-m-6"></div>
		</div>
	</div>

	<!-- break -->
	<div class="width-100 height-10"></div>

	<?php } ?>