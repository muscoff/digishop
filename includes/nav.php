<?php  
//Get category
$data = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);

//Parent Array
$parent = array();

//Child Array
$childRen = array();

foreach ($data as $data) {
	if($data['parent'] == 0){
		array_push($parent, array('id'=>$data['id'], 'category'=>$data['category'], 'parent'=>$data['parent']));
	}else{
		array_push($childRen, array('id'=>$data['id'], 'category'=>$data['category'], 'parent'=>$data['parent']));
	}
}

// Get logo
$logoData = json_decode(file_get_contents(url_location.'api/control/fetch.php'),true);
$logoImage = $logoData['logo'];

?>
	
	<!-- nav -->
	<div id="fixed" class="width-100 height-10 white-bg flex-row border-bottom-1 z-index-1">
		<div class="width-10 width-s-20 width-m-20 width-l-20">
			<div class="img-container-100 display-<?=((!empty($logoData) & !empty($logoImage))?'block':'none');?>">
				<img src="<?=$logoImage;?>" id="openSideNav" />
			</div>
		</div>

		<div class="width-60 hide-on-small-only height-auto flex-column justify-content-center">
			<div class="nav">
				<div class="nav-wrapper">
					<ul class="inline-block allerBd">
						<?php foreach($parent as $parent): ?>
							<li class="uppercase"><a href="<?=url_location;?>product.php?cat=<?=$parent['id'];?>" target="blank"><?=$parent['category'];?></a>
								<ul>
									<?php foreach($childRen as $children): ?>
										<?php if($children['parent'] == $parent['id']): ?>
											<li>
												<a href="<?=url_location;?>product.php?cat=<?=$children['id'];?>" class="red-hover" target="blank">
													<?=$children['category'];?>
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>

		<div class="width-30 width-s-80 width-m-80 width-l-80" id="navInput">
			<div class="full flex-row align-items-center">
				<div class="row align-items-center">
					<div class="col-9">
						<input type="text" name="" id="search">
					</div>
					<div class="col-3">
						<a href="<?=url_location;?>viewcart.php" target="blank">
							<span class="padding-left-10">Cart</span>(<span id="cart"></span>)
						</a>
					</div>	
				</div>
			</div>
		</div>
	</div>



<script type="text/javascript">
	//Get screen width
	let myScreenWidth = window.innerWidth;

	if(myScreenWidth<=420){
		document.querySelector('#openSideNav').addEventListener('click', e=>{
			let sideBG = document.querySelector('#sideNavBG');
			let sideContent = document.querySelector('#sideNavContent');
			sideBG.classList.remove('width-s-0');
			sideBG.classList.add('width-s-100');
			sideContent.classList.remove('width-s-0');
			sideContent.classList.add('width-s-80');
		});
	}

	if(myScreenWidth<=620 & myScreenWidth>420){
		document.querySelector('#openSideNav').addEventListener('click', e=>{
			let sideBG = document.querySelector('#sideNavBG');
			let sideContent = document.querySelector('#sideNavContent');
			sideBG.classList.remove('width-m-0');
			sideBG.classList.add('width-m-100');
			sideContent.classList.remove('width-m-0');
			sideContent.classList.add('width-m-80');
		});
	}

	if(myScreenWidth<=820 & myScreenWidth>620){
		document.querySelector('#openSideNav').addEventListener('click', e=>{
			let sideBG = document.querySelector('#sideNavBG');
			let sideContent = document.querySelector('#sideNavContent');
			sideBG.classList.remove('width-l-0');
			sideBG.classList.add('width-l-100');
			sideContent.classList.remove('width-l-0');
			sideContent.classList.add('width-l-60');
		});
	}
</script>