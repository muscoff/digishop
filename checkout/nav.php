<?php  
// Get Logo
$logoData = json_decode(file_get_contents(url_location.'api/control/fetch.php'),true);
$logo = $logoData['logo'];
?>
<div class="fixed width-100 height-10 flex-row border-bottom-1 z-index-1 white-bg">
	<div class="width-10 width-s-20 width-m-20 overflow-hidden">
		<div class="img-container-100"><img src="<?=$logo;?>" id="openSideNav"></div>
	</div>
	<div class="width-80 width-s-60 width-m-60 height-auto">
		<div class="width-auto height height-auto flex-column justify-content-center align-items-center">
			<span class="font-allerBd deep-grey-text uppercase">secure checkout</span>
		</div>
	</div>
	<div class="width-10 width-s-20 width-m-20 height-auto">
		<div class="full flex-row align-items-center">
			<a href="<?=url_location;?>viewcart.php" target="blank">
				<span>Cart</span>(<span id="cart"></span>)
			</a>
		</div>
	</div>
</div>

<script type="text/javascript">
	//get screen width
	let sWidth = window.innerWidth;

	if(sWidth<=420){
		document.querySelector('#openSideNav').addEventListener('click', e=>{
			let sideBG = document.querySelector('#sideNavBG');
			let sideContent = document.querySelector('#sideNavContent');
			sideBG.classList.remove('width-s-0');
			sideBG.classList.add('width-s-100');
			sideContent.classList.remove('width-s-0');
			sideContent.classList.add('width-s-80');
		});
	}

	if(sWidth<=620 & sWidth>420){
		document.querySelector('#openSideNav').addEventListener('click', e=>{
			let sideBG = document.querySelector('#sideNavBG');
			let sideContent = document.querySelector('#sideNavContent');
			sideBG.classList.remove('width-m-0');
			sideBG.classList.add('width-m-100');
			sideContent.classList.remove('width-m-0');
			sideContent.classList.add('width-m-80');
		});
	}

	//check and act
	
</script>