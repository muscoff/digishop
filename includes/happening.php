<?php  
//Get page data
$data = json_decode(file_get_contents(url_location.'api/pages/page_two/fetch.php'),true);

if(!empty($data)){

//Get Category data
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);
$parent = array();

$firstTitle = null;
$secondTitle = null;

foreach ($cat as $cat) {
	if($cat['parent']==0){
		$arr = array('id'=>$cat['id'], 'category'=>$cat['category'], 'parent'=>$cat['parent']);
		array_push($parent, $arr);
	}
}

foreach ($parent as $parent) {
	if($parent['id'] == $data['first_link']){
		$firstTitle = $parent['category'];
	}

	if($parent['id']==$data['second_link']){
		$secondTitle = $parent['category'];
	}
}

?>
<!-- Good things are happening -->
	<div class="width-100 height-90 height-s-50 height-m-50 overflow-hidden banner">
		<img src="<?=$data['image'];?>">
		<div class="full flex-column justify-content-center align-items-center">
			<div class="capitalize font-sweet font-20 font-s-15 font-m-20 center-text">
				-<?=((!empty($data['first_cap']))?$data['first_cap']:'');?>-
			</div>
			<div class="uppercase center-text font-60 font-s-20 font-m-30 font-allerBd bold-text deep-grey-text">
				<div><?=((!empty($data['second_cap']))?$data['second_cap']:'');?></div> 
				<div><?=((!empty($data['third_cap']))?$data['third_cap']:'');?></div>
			</div>
			<div class="margin-top-20 flex-row justify-content-center">
				<div class="uppercase font-allerBd font-15 font-s-10 padding-right-10">
					<a href="<?=url_location;?>product.php?cat=<?=$data['first_link'];?>" class="white-text">
						<span class="deep-grey-bg padding-all-10"><?=((!empty($firstTitle))?$firstTitle:"");?>'s new arrival</span>
					</a>
				</div>
				<div class="uppercase font-allerBd font-15 font-s-10">
					<a href="<?=url_location;?>product.php?cat=<?=$data['second_link'];?>" class="white-text">
						<span class="deep-grey-bg padding-all-10">
							<?=((!empty($secondTitle))?$secondTitle:"");?>'s new arrival 
						</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- break -->
	<div class="width-100 height-10"></div>

	<?php } ?>