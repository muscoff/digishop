<?php  
session_start();
if(!empty($_SESSION['id']) & !empty($_SESSION['cart'])){
	if(!empty($_SESSION['details'])){
		$first = $_SESSION['details']['first_name'];
		$last = $_SESSION['details']['last_name'];
		$address = $_SESSION['details']['address'];
		$city = $_SESSION['details']['town'];
		$email = $_SESSION['details']['email'];
		$number = $_SESSION['details']['number'];

?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/head.php"; ?>

<?php include "nav.php"; ?>

<!-- break -->
<div class="width-100 height-5"></div>

<!-- background color cover -->
<div class="off-white-bg">
	<!-- break -->
	<div class="width-100 height-10"></div>

	<div class="width-80 width-s-100 margin-auto">
		<div class="row">
			<div class="col-7 col-s-12 col-m-12">
				<div class="padding-all-10 white-bg border-bottom-3-grey">
					<div class="font-allerBd uppercase deep-grey-text">1. shipping address</div>
				</div>

				<div class="font-allerRg white-bg padding-all-10">
					<div class="font-allerBd"><?=$first.' '.$last;?></div>
					<div><?=$address;?></div>
					<div><?=$city;?></div>
					<div><?=$email;?></div>
					<div><?=$number;?></div>
				</div>

				<div class="width-100 height-5"></div>

				<div class="padding-all-10 white-bg border-bottom-3-grey">
					<div class="font-allerBd uppercase deep-grey-text">2. Pay </div>
				</div>

				<div class="white-bg">
					<!-- break -->
					<!-- <div class="width-100 height-5"></div> -->
					<form action="<?=url_location;?>charge/" method="post" id="payment-form">
						<div class="form-row">
							<div id="card-element">
								<!-- A Stripe Element will be inserted here. -->
							</div>

								<!-- Used to display form errors. -->
							<div id="card-errors" role="alert"></div>
						</div>

						<button class="deep-grey-bg white-text font-allerBd margin-top-10">Submit Payment</button>
					</form>
				</div>

				<!-- break -->
				<div class="width-100 height-10"></div>
			</div>

			<div class="col-1 col-s-12 col-m-12"></div>

			<div class="col-4 col-s-12 col-m-12">
				<div class="padding-all-10 white-bg">
					<div class="row">
						<div class="col-8 capitalize font-allerRg">subtotal</div>
						<div class="col-4 font-allerBd right-text">$<span id="sub"></span></div>
						<div class="col-12 height-2"></div>
						<div class="col-8 font-allerRg capitalize">shipping</div>
						<div class="col-4 font-allerRg right-text"><?=$_SESSION['shipping'];?></div>
						<div class="col-12 height-2"></div>
						<div class="col-8 font-allerRg capitalize">estimated tax</div>
						<div class="col-4 font-allerRg right-text">--</div>
						<div class="col-12 height-2"></div>
						<div class="col-8 font-allerBd uppercase">Total</div>
						<div class="col-4 font-allerBd right-text">$<span><?=$_SESSION['final'];?></span></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- break -->
	<div class="width-auto height-5"></div>
</div>

<!-- break -->
<div class="width-100 height-5"></div>

<script type="text/javascript">
	function getSubTotal(){
		let sub = document.querySelector('#sub');
		fetch('<?=url_location;?>cart.php?price')
		.then(response=>response.json())
		.then(response=> {sub.innerHTML = response.price})
		.catch(error=>console.log(error));
	}
	getSubTotal();

	function getCart(){
		let cart = document.querySelector('#cart');
		fetch('<?=url_location;?>cart.php?total')
		.then(response=>response.json())
		.then(response=>cart.innerHTML = response.total)
		.catch(error=>console.log(error));
	}
	getCart();
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="<?=url_location;?>js/charge.js" type="text/javascript"></script>

<!-- side nav -->
<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/side_nav.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/footer.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/tail.php"; ?>

<?php 
}
else{
	include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
	header('Location: '.url_location.'checkout/add.php');
}
}else{
	include $_SERVER['DOCUMENT_ROOT']."/digishop/definitions/def.php";
	header('Location: '.url_location.'product.php');
}
?>