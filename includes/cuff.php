<?php  

// Get Page Data
$data = json_decode(file_get_contents(url_location.'api/pages/page_seven/fetch.php'),true);

if(!empty($data)){

$link = $data['page_link'];

//Get Category
$cat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);

//get parent
$parent = array();

foreach ($cat as $cat) {
	if($cat['parent'] == 0){
		$arr = array('id'=>$cat['id'], 'category'=>$cat['category'], 'parent'=>$cat['parent']);
		array_push($parent, $arr);
	}
}

$title = null;
foreach ($parent as $parent) {
	if($parent['id'] == $link){
		$title = $parent['category'];
	}
}

?>


	<!-- off the cuff blog -->
	<div class="width-100 height-90 height-s-50 height-m-50 banner yellow-bg">
		<img src="<?=$data['image'];?>">
		<div class="full flex-column justify-content-center align-items-center">
			<div class="capitalize font-20 font-s-12 font-m-12 italic"><?=$data['first_cap'];?> </div>
			<div class="uppercase center-text font-allerBd font-40 font-s-20 font-m-30 bold-text deep-grey-text word-spacing-0-2 margin-top-10">
				<div><?=$data['second_cap'];?></div> 
				<div><?=$data['third_cap'];?></div>
			</div>
			<div class="uppercase font-allerBd font-20 font-s-15 margin-top-10">
				<a href="<?=url_location;?>product.php?cat=<?=$link;?>" class="white-text">
					<span class="padding-all-13 padding-s-all-5 padding-m-all-5 deep-grey-bg"><?=$title;?> collection</span>
				</a>
			</div>
		</div>
	</div>

	<!-- Break -->
	<div class="width-100 height-10"></div>

	<?php } ?>