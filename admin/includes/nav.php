<?php  
//session_start();

?>
<div class="width-100 height-10 flex-row align-items-center black-bg">
	<div class="ul-inline padding-left-10">
		<ul class="allerRg">
			<li><a href="<?=url_location;?>admin/pages.php" class="white-text yellow-hover padding-right-10">Pages</a></li>
			<li><a href="<?=url_location;?>admin/brand.php" class="white-text yellow-hover padding-right-10">Brand</a></li>
			<li><a href="<?=url_location;?>admin/categories.php" class="white-text yellow-hover padding-right-10">Categories</a></li>
			<li><a href="<?=url_location;?>admin/product.php" class="white-text yellow-hover padding-right-10">Products</a></li>
			<li><a href="<?=url_location;?>admin/order.php" class="white-text yellow-hover padding-right-10">Order</a></li>
			<li><a href="<?=url_location;?>admin/settings.php" class="white-text yellow-hover padding-right-10">Settings</a></li>
		</ul>
	</div>
	<div class="absolute right-1 font-allerRg capitalize">
		<a href="<?=url_location;?>admin/logout.php" class="white-text">logout</a>
	</div>
</div>