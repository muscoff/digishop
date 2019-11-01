<?php  
session_start();
if(!empty($_SESSION['id']) & !empty($_SESSION['cart'])){
	$sum = array();
	$final_total = null;
	foreach ($_SESSION['cart'] as $cart) {
		array_push($sum, $cart['total']);
	}
	$final_total = array_sum($sum) + $_SESSION['shipping'];
	$_SESSION['final'] = $final_total;

	$msg = null;
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

				<div>
					<?php  
						if(isset($_POST['next'])){
							$first_name = $_POST['first_name'];
							$last_name = $_POST['last_name'];
							$address = $_POST['address'];
							$city = $_POST['city'];
							$state = $_POST['state'];
							$postal_code = $_POST['postal_code'];
							$country = $_POST['country'];
							$email = $_POST['email'];
							$number = $_POST['number'];

							$input = [$first_name, $last_name, $address, $city, $state, $postal_code, $email, $number];

							if(in_array('', $input)){
								$msg = 'Please make sure to fill in all the input fields to continue. Happy paying!!!';
							}else{

							if(!empty($_SESSION['details'])){
								$_SESSION['details']['first_name'] = $first_name;
								$_SESSION['details']['last_name'] = $last_name;
								$_SESSION['details']['address'] = $address;
								$_SESSION['details']['town'] = $city;
								$_SESSION['details']['state'] = $state;
								$_SESSION['details']['postal_code'] = $postal_code;
								$_SESSION['details']['country'] = $country;
								$_SESSION['details']['email'] = $email;
								$_SESSION['details']['number'] = $number;
							}else{
								$_SESSION['details']['first_name'] = $first_name;
								$_SESSION['details']['last_name'] = $last_name;
								$_SESSION['details']['address'] = $address;
								$_SESSION['details']['town'] = $city;
								$_SESSION['details']['state'] = $state;
								$_SESSION['details']['postal_code'] = $postal_code;
								$_SESSION['details']['country'] = $country;
								$_SESSION['details']['email'] = $email;
								$_SESSION['details']['number'] = $number;
							}

							header('Location: pay.php');
							}
						}

					?>
					<form method="POST" action="">
						<div class="padding-all-10 white-bg">
							<div class="row">
								<div class="col-6 col-s-12 col-m-12 padding-all-10">
									<input type="text" class="transparent border-all-1 font-allerRg" name="first_name" placeholder="First Name" value="<?=((!empty($_SESSION['details']))?$_SESSION['details']['first_name']:'');?>" required />
								</div>
								<div class="col-6 col-s-12 col-m-12 padding-all-10">
									<input type="text" class="transparent border-all-1 font-allerRg" name="last_name" placeholder="Last Name" value="<?=((!empty($_SESSION['details']))?$_SESSION['details']['last_name']:'');?>" required />
								</div><br /> <br />
								<div class="col-12 padding-all-10">
									<input type="text" name="address" class="transparent border-all-1 font-allerRg" placeholder="Address" value="<?=((!empty($_SESSION['details']))?$_SESSION['details']['address']:'');?>" required/>
								</div>

								<div class="col-6 col-s-12 col-m-12 padding-all-10">
									<input type="text" class="transparent border-all-1 font-allerRg" name="city" placeholder="Town/City" value="<?=((!empty($_SESSION['details']))?$_SESSION['details']['town']:'');?>" required/>
								</div>
								<div class="col-3 col-s-6 col-m-6 padding-all-10">
									<input type="text" name="state" value="<?=((!empty($_SESSION['details']))?$_SESSION['details']['state']:'');?>" placeholder="State" required />
								</div>

								<div class="col-3 col-s-6 col-m-6 padding-all-10">
									<input type="text" class="transparent border-all-1 font-allerRg" name="postal_code" placeholder="Postcode" value="<?=((!empty($_SESSION['details']))?$_SESSION['details']['postal_code']:'');?>" required />
								</div>

								<div class="col-6 col-s-12 col-m-12 padding-all-10">
									<input type="text" name="email" class="transparent border-all-1 font-allerRg" placeholder="Email" value="<?=((!empty($_SESSION['details']))?$_SESSION['details']['email']:'');?>" required />
								</div>

								<div class="col-6 col-s-12 col-m-12 padding-all-10">
									<input type="text" name="number" class="transparent border-all-1 font-allerRg" placeholder="Number" value="<?=((!empty($_SESSION['details']))?$_SESSION['details']['number']:'');?>" required />
								</div>

								<div class="col-12 col-s-12 col-m-12 padding-all-10">
									<input type="text" name="country" class="transparent border-all-1 font-allerRg" placeholder="Country" value="<?=((!empty($_SESSION['details']))?$_SESSION['details']['country']:'');?>" required />
								</div>

								<div class="font-allerRg font-12 grey-text padding-all-10">
									Phone number and Email will be used for order delivery updates only
								</div>
								<div class="font-allerRg red-text padding-all-10"><?=$msg;?></div>
							</div>
						</div>
						<!-- break -->
						<div class="width-100 height-5"></div>
						<div>
							<div class="row">
								<div class="col-5 col-s-12 col-m-12">
									<input type="submit" class="width-100 height-8 deep-grey-bg white-text uppercase" name="next" value="next">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="col-1 col-s-12 col-m-12"></div>

			<div class="col-4 col-s-12 col-m-12">
				<div class="padding-all-10 white-bg">
					<div class="row">
						<div class="col-8 capitalize font-allerRg">subtotal</div>
						<div class="col-4 font-allerBd right-text">$<span id="sub"></span></div>
						<div class="col-12 height-2"></div>
						<div class="col-8 font-allerRg capitalize">shipping</div>
						<div class="col-4 font-allerRg right-text">$<span><?=$_SESSION['shipping'];?></span></div>
						<div class="col-12 height-2"></div>
						<div class="col-8 font-allerRg capitalize">estimated tax</div>
						<div class="col-4 font-allerRg right-text">--</div>
						<div class="col-12 height-2"></div>
						<div class="col-8 font-allerBd uppercase">Total</div>
						<div class="col-4 font-allerBd right-text">$<span><?=$final_total;?></span></div>
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

<!-- side nav -->
<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/side_nav.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/footer.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/tail.php"; ?>

<?php }else{header('Location: '.url_location.'product.php');} ?>