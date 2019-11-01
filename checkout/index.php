<?php  
session_start();
if(!empty($_SESSION['id']) & !empty($_SESSION['cart'])){
	if(!empty($_SESSION['details'])){
		$sum = array();
		foreach ($_SESSION['cart'] as $cartItem) {
			array_push($sum, $cartItem['total']);
		}
		// Calculate total
		$sumValue = array_sum($sum);
		$_SESSION['final'] = $sumValue + $_SESSION['shipping'];
		header('Location: pay.php');
	}else{

$msg = isset($_GET['msg'])?$_GET['msg']:null;

?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/head.php"; ?>

<?php include "nav.php"; ?>

<!-- break -->
<div class="width-100 height-10"></div>

<!-- background color cover -->
<div class="off-white-bg">
	<!-- break -->
	<div class="width-100 height-10 flex-column justify-content-center align-items-center">
		<div class="font-allerBd"><?=$msg;?></div>
	</div>

	<div class="width-60 width-s-100 width-m-80 margin-auto border-all-1 white-bg">
		<div class="width-auto height-10 flex-column justify-content-center align-items-center">
			<span class="uppercase font-allerBd">checkout</span>
		</div>

		<a href="<?=url_location;?>checkout/add.php">
		<div class="width-80 height-8 margin-auto flex-column justify-content-center align-items-center border-all-1 off-white-bg btn">
			<span class="uppercase font-allerRg">guest checkout</span>
		</div>
		</a>

		<!-- break -->
		<div class="width-auto height-2"></div>

		<div class="center-text font-allerRg capitalize light-grey-text">or</div>

		<!-- break -->
		<div class="width-auto height-4"></div>
		<div class="width-80 margin-auto center-text font-allerRg light-grey-text">
			Sign in to checkout faster using your saved information.
		</div>

		<!-- break -->
		<div class="width-auto height-4"></div>

		<div class="width-80 margin-auto">
			<form method="POST" action="<?=url_location;?>api/customer_login/checkout_login.php">
				<input type="hidden" name="checkout_login_token" value="<?=$_SESSION['checkout_login_token'];?>">
				<input type="text" placeholder="Email" class="transparent border-all-1" name="email"><br /> <br />
				<input type="password" placeholder="Password" class="input transparent border-all-1" name="password"><br /><br />
				<div class="blue-text capitalize font-allerRg">forgotten password??</div> <br /> <br />
				<input type="submit" class="width-100 height-8 white-text deep-grey-bg uppercase allerBd" value="sign in" name="submit">
			</form>
		</div>

		<!-- break -->
		<div class="width-100 height-5"></div>
	</div>
	<!-- break -->
	<div class="width-auto height-5"></div>
</div>

<!-- break -->
<div class="width-100 height-5"></div>

<!-- side nav -->
<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/side_nav.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/footer.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/script.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/tail.php"; ?>

<?php 
}
}else{
	include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
	header('Location: '.url_location.'product.php');
	} 
?>