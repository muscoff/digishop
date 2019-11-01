<?php  

//Get Page Data
$data = json_decode(file_get_contents(url_location.'api/pages/page_three/fetch.php'),true);

if(!empty($data)){

$firstTitle = null;
$secondTitle = null;

//Get category
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);

foreach ($cat as $cat) {
	if($cat['id'] == $data['first_link']){
		$firstTitle = $cat['category'];
	}

	if($cat['id'] == $data['second_link']){
		$secondTitle = $cat['category'];
	}
}

?>
	<!-- wear now pay later -->
	<div class="width-100 height-40 height-s-30 deep-blue-bg flex-column justify-content-center align-items-center">
		<div class="overflow-hidden"> <!-- width-40 width-s-100 height-auto height-s-30 margin-auto -->
			<div class=""> <!-- width-auto width-s-100 height-20 height-s-15 overflow-hidden -->
				<div class="font-allerBd font-50 font-s-20 font-m-30 white-text center-text uppercase"><?=$data['first_cap'];?></div>
				<!-- <div class="img-container-100">
					<img src="images/after.png">
				</div> -->
			</div>

			<div class="uppercase font-40 font-s-20 font-m-30 center-text font-allerBd white-text"><?=$data['second_cap'];?></div>

			<div class="ul-inline center-text margin-top-10">
				<ul>
					<li class="padding-right-10 uppercase font-allerBd">
						<a href="<?=url_location;?>product.php?cat=<?=$data['first_link'];?>" class="white-text"><span class="border-bottom-3-white">shop <?=$firstTitle;?></span></a>
					</li>
					<li class="padding-right-10 uppercase font-allerBd">
						<a href="<?=url_location;?>product.php?cat=<?=$data['second_link'];?>" class="white-text"><span class="border-bottom-3-white">shop <?=$secondTitle;?></span></a>
					</li>
					<!-- <li class="padding-right-10 uppercase font-allerBd">
						<a href="" class="white-text"><span class="border-bottom-3-white">learn more</span></a>
					</li> -->
				</ul>
			</div>

		</div>
	</div>

	<?php } ?>