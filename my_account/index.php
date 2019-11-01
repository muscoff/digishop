<?php  
session_start();
session_regenerate_id(true);

$msg = isset($_GET['msg'])?$_GET['msg']:null;

if(isset($_SESSION['customer_email']) & !empty($_SESSION['customer_email'])){

?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/head.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/nav.php"; ?>

<?php  
// check to see if $_SESSION['details'] is empty
$count = count($_SESSION['details']);
//echo $count;

?>

<!-- Container -->
<div class="off-white-bgs">
	<div class="relative padding-all-5">
		<div class="absolute capitalize deep-grey-text font-allerBd right-2">
			<a href="<?=url_location;?>api/customer_login/logout.php">logout</a>
		</div>
	</div>
	<!-- break -->
	<div class="width-100 height-10 flex-column justify-content-center align-items-center">
		<div class="font-allerBd capitalize"><?=((!empty($msg))?$msg:'');?></div>
	</div>

	<div class="white-bg">
		<div class="container">
			<div class="row">
				<div class="col-3 col-s-12 font-allerRg">
					<div class="blue-text">Profile</div>
				</div>
				<div class="col-9 col-s-12">
					<form method="POST" action="<?=url_location;?>api/customer_account/<?=(($count>0)?'edit':'create');?>.php">
						<input type="hidden" value="<?=$_SESSION['account_token'];?>" name="account_token" />

						<?php if(!empty($_SESSION['details']['id'])): ?>
							<input type="hidden" name="id" value="<?=$_SESSION['details']['id'];?>">
						<?php endif; ?>
						<div class="row">
							<div class="col-6 col-s-12 padding-all-10">
								<div>
									<input type="text" class="transparent border-all-1" name="first_name" placeholder="First Name" value="<?=(($count>0)?$_SESSION['details']['first_name']:'');?>" />
								</div>
							</div>
							<div class="col-6 col-s-12 padding-all-10">
								<div>
									<input type="text" class="transparent border-all-1" name="last_name" placeholder="Last Name" value="<?=(($count>0)?$_SESSION['details']['last_name']:'');?>" />
								</div>
							</div>
							<div class="col-12 padding-all-10">
								<div>
									<input type="text" class="transparent border-all-1" name="address" placeholder="address" value="<?=(($count>0)?$_SESSION['details']['address']:'');?>" />
								</div>
							</div>
							<div class="col-6 col-s-12 padding-all-10">
								<div>
									<input type="text" class="transparent border-all-1" name="town" placeholder="Town" value="<?=(($count>0)?$_SESSION['details']['town']:'');?>" />
								</div>
							</div>
							<div class="col-3 col-s-6 padding-all-10">
								<div>
									<input type="text" name="state" placeholder="state" value="<?=(($count>0)?$_SESSION['details']['state']:'');?>" />
								</div>
							</div>
							<div class="col-3 col-s-6 padding-all-10">
								<div><input type="text" class="transparent border-all-1" name="postal_code" placeholder="Postal code" value="<?=(($count>0)?$_SESSION['details']['postal_code']:'');?>" /></div>
							</div>
							<div class="col-6 col-s-12 padding-all-10">
								<div><input type="email" class="input transparent border-all-1" name="email" placeholder="Email" value="<?=(($count>0)?$_SESSION['details']['email']:$_SESSION['customer_email']);?>" /></div>
							</div>
							<div class="col-6 col-s-12 padding-all-10">
								<div><input type="text" class="transparent border-all-1" name="number" placeholder="Number" value="<?=(($count>0)?$_SESSION['details']['number']:'');?>" /></div>
							</div>

							<div class="col-12 col-s-12 padding-all-10">
								<div><input type="text" class="transparent border-all-1" name="country" placeholder="Country" value="<?=(($count>0)?$_SESSION['details']['country']:'');?>" /></div>
							</div>

							<div class="col-12 padding-all-10">
								<div>
									<input type="submit" value="<?=(($count>0)?'Update':'Submit');?>" class="width-100 deep-grey-bg white-text font-allerBd" name="">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- break -->
	<div class="width-100 height-5"></div>

</div>

<!-- break -->
<div class="width-100 height-5"></div>

<!-- side nav -->
<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/side_nav.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/footer.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/script.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/tail.php"; ?>

<?php }else{header('Location: ../index.php');} ?>