	<!-- top nav -->
	<div class="width-100 height-6 flex-column justify-content-center black-bg hide-on-medium-small" id="topNav">
		<div class="ul-inline white-text font-13 absolute right-0">
			<ul class="allerRg">
				<li class="padding-right-10">
					<a href="<?=((isset($_SESSION['customer_email']))?url_location.'api/customer_login/logout.php':url_location.'sign_in/');?>" class="white-text"><?=((isset($_SESSION['customer_email']))?'Logout':'Sign In');?></a>
				</li>
				<li class="padding-right-10"><a href="<?=url_location;?>product.php" class="white-text">View All Products</a></li>
			</ul>
		</div>
		<div class="absolute padding-left-10 display-<?=((isset($_SESSION['customer_email']))?'block':'none');?>">
			<a href="<?=url_location;?>my_account/"><span class="white-text">My Account</span></a>
		</div>
	</div>