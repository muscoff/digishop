<?php  
include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/PageOne.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/Category.php";

// set db
$DBH = new DB();
$db = $DBH->connect();

//PageOne
$page = new PageOne($db);
$data = $page->fetch();

if(!empty($data)){

$first_link = $data['first_link'];
$second_link = $data['second_link'];
$third_link = $data['third_link'];

$first_title = null; $second_title = null; $third_title = null;

//Get category
$cat = new Category($db);
$catData = $cat->getParent();

//foreach
foreach ($catData as $value) {
	if($value['id'] == $first_link){
		$first_title = $value['category'];
	}

	if($value['id'] == $second_link){
		$second_title = $value['category'];
	}

	if($value['id'] == $third_link){
		$third_title = $value['category'];
	}
}

?>
<!-- first banner -->
	<div class="width-100 height-40 height-s-30 banner white-text overflow-hidden">
		<img src="<?=$data['image'];?>">
		<div class="full flex-column justify-content-center align-items-center"> <!-- width-70 width-s-100 height-40 height-s-30 margin-auto -->
			<div class="font-30 font-s-15 font-m-20 font-l-20 margin-top-10 font-sweet word-spacing-0-2 capitalize">
				-<?=((!empty($data['first_cap']))?$data['first_cap']:'');?>-
			</div>
			<div class="font-60 font-s-20 font-m-20 font-l-30 uppercase bold-text font-allerBd">
				<?=((!empty($data['second_cap']))?$data['second_cap']:'');?>
			</div>

			<div class="ul-inline font-s-12">
				<ul>
					<li class="padding-right-10 uppercase font-allerBd">
						<a href="<?=url_location;?>product.php?cat=<?=((!empty($first_link))?$first_link:'');?>" class="white-text">
							<span class="border-bottom-3-white">shop <?=((!empty($first_title))?$first_title:'');?></span>
						</a>
					</li>
					<li class="padding-right-10 uppercase font-allerBd">
						<a href="<?=url_location;?>product.php?cat=<?=((!empty($second_link))?$second_link:'');?>" class="white-text">
							<span class="border-bottom-3-white">shop <?=((!empty($second_title))?$second_title:'');?></span>
						</a>
					</li>
					<li class="padding-right-10 uppercase font-allerBd">
						<a href="<?=url_location;?>product.php?cat=<?=((!empty($third_link))?$third_link:'');?>" class="white-text">
							<span class="border-bottom-3-white">shop <?=((!empty($third_title))?$third_title:'');?></span>
						</a>
					</li>
				</ul>
			</div>

			<div class="margin-top-10">
				Online only. <a href="" class="white-text"><span class="border-bottom-1-white">See details</span></a>
			</div>
		</div>	
	</div>

	<!-- break -->
	<div class="width-100 height-5 height-s-1"></div>

	<?php } ?>