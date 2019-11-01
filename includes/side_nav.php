<?php  
// Get logo
$getLogo = json_decode(file_get_contents(url_location.'api/control/fetch.php'),true);
$displayLogo = $getLogo['logo'];

// Get Categories
$getCat = json_decode(file_get_contents(url_location.'api/category/fetch.php'),true);

// Parent and Child array
$parentCategory = array();
$childCategory = array();

foreach ($getCat as $getCat) {
	if($getCat['parent'] == 0){
		array_push($parentCategory, $getCat);
	}else{
		array_push($childCategory, $getCat);
	}
}

//echo json_encode($parentCategory);

?>
<div class="">
	<div id="sideNavBG" class="fixed top-0 show-on-medium-small width-s-0 width-m-0 width-l-0 height-100 z-index-1 opacity-05 black-bg"></div>
	<div id="sideNavContent" class="fixed top-0 show-on-medium-small width-s-0 width-m-0 width-l-0 height-100 z-index-1 white-bg overflow-auto">
		<!-- Logo -->
		<div class="width-s-20 width-m-30 width-l-30 margin-auto height-s-10 height-m-15">
			<div class="img-container-100">
				<img src="<?=$displayLogo;?>" />
			</div>
		</div>
		<!-- end of logo -->

		<div class="padding-all-5 font-allerBd capitalize center-text red-bg white-text">menu</div>

		<!-- My Account -->
		<div class="display-<?=((isset($_SESSION['customer_email']))?'block':'none');?>">
			<a href="<?=url_location;?>my_account/">
				<div class="padding-all-5 font-allerBd capitalize center-text">my account</div>
			</a>
		</div>

		<a href="<?=url_location;?>"><div class="padding-all-5 font-allerBd capitalize center-text">home</div></a>

		<a href="<?=url_location;?>product.php"><div class="padding-all-5 font-allerBd capitalize center-text">view all products</div></a>

		<a href="<?=url_location;?>viewcart.php"><div class="padding-all-5 font-allerBd capitalize center-text">Cart</div></a>

		<div class="display-<?=((isset($_SESSION['cart']) & !empty($_SESSION['cart']))?'block':'none');?>">
			<a href="<?=url_location;?>checkout/"><div class="padding-all-5 font-allerBd capitalize center-text">Checkout</div></a>
		</div>

		<a href="<?=((isset($_SESSION['customer_email']))?url_location.'api/customer_login/logout.php':url_location.'sign_in/');?>"><div class="padding-all-5 font-allerBd capitalize center-text"><?=((isset($_SESSION['customer_email']))?'logout':'Sign In');?></div></a>

		<div class="padding-all-5 font-allerBd capitalize center-text red-bg white-text">categories</div>

		<div>
			<?php foreach($parentCategory as $key=> $parentCategory): ?>
				<div class="padding-all-5 font-allerBd capitalize center-text menu-item cursor-pointer">
					<!-- <a href="<?=url_location;?>product.php?cat=<?=$parentCategory['id'];?>"> -->
						<?=$parentCategory['category'];?>
					<!-- </a> -->
					<div class="sub hide-menu off-white-bg">
						<?php foreach($childCategory as $childC): ?>
							<?php if($childC['parent'] == $parentCategory['id']): ?>
								<div class="padding-all-5">
									<a href="<?=url_location;?>product.php?cat=<?=$childC['id'];?>">
										<?=$childC['category'];?>
									</a>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</div>

<script type="text/javascript">
	let menu = document.querySelectorAll('.menu-item');

	for(let i=0; i<menu.length; i++){
		menu[i].setAttribute('onclick', "showSub("+i+")");
	}

	showSub = i =>{
		let subItem = document.querySelectorAll('.sub');
		subItem[i].classList.remove('hide-menu');
		subItem[i].classList.add('show-menu');
		menu[i].setAttribute('onclick', "hideSub("+i+")");
	}

	hideSub = i =>{
		let subItem = document.querySelectorAll('.sub');
		subItem[i].classList.remove('show-menu');
		subItem[i].classList.add('hide-menu');
		menu[i].setAttribute('onclick', "showSub("+i+")");
	}

	// get screen width
	let screenW = window.innerWidth;

	if(screenW<=420){
		document.querySelector('#sideNavBG').addEventListener('click', e=>{
			let sideBg = document.querySelector('#sideNavBG');
			let sideContent = document.querySelector('#sideNavContent');
			sideBg.classList.remove('width-s-100');
			sideBg.classList.add('width-s-0');
			sideContent.classList.remove('width-s-80');
			sideContent.classList.add('width-s-0');
		});
	}

	if(screenW<=620 & screenW>420){
		document.querySelector('#sideNavBG').addEventListener('click', e=>{
			let sideBg = document.querySelector('#sideNavBG');
			let sideContent = document.querySelector('#sideNavContent');
			sideBg.classList.remove('width-m-100');
			sideBg.classList.add('width-m-0');
			sideContent.classList.remove('width-m-80');
			sideContent.classList.add('width-m-0');
		});
	}

	if(screenW<=820 & screenW>620){
		document.querySelector('#sideNavBG').addEventListener('click', e=>{
			let sideBg = document.querySelector('#sideNavBG');
			let sideContent = document.querySelector('#sideNavContent');
			sideBg.classList.remove('width-l-100');
			sideBg.classList.add('width-l-0');
			sideContent.classList.remove('width-l-60');
			sideContent.classList.add('width-l-0');
		});
	}


</script>