<?php  
session_start();
session_regenerate_id(true);

$msg = isset($_GET['msg'])?$_GET['msg']:null;

if(isset($_SESSION['sign_in_token']) & isset($_SESSION['sign_up_token'])){

?>
<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/head.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/topnav.php"; ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/digishop/includes/nav.php"; ?>

<div class="off-white-bg">
	<!-- break -->
	<div class="width-100 height-10 flex-column justify-content-center align-items-center">
		<div class="font-allerBd"><?=$msg;?></div>
	</div>

	<div class="width-60 width-s-100 margin-auto white-bg border-all-1 padding-all-10">
		<div class="row">
			<div class="col-6 col-s-12 margin-top-10">
				<div class="center-text uppercase font-allerBd deep-grey-text bold-text">welcome back</div><br />
				<div class="width-80 margin-auto">
					<form method="POST" action="<?=url_location;?>api/customer_login/login.php">
					<input type="hidden" name="sign_in_token" value="<?=$_SESSION['sign_in_token'];?>">
					<div><input type="text" name="email" placeholder="Email" /></div><br />

					<div><input type="password" class="input" name="password" placeholder="Password" /></div><br />

					<div><input type="submit" name="sign_in" class="uppercase font-allerBd width-100 deep-grey-bg white-text" value="sign in"></div>
					</form>
				</div>
			</div>
			<div class="col-6 col-s-12 margin-top-10">
				<div class="center-text uppercase font-allerBd deep-grey-text bold-text">new to digishop?</div><br />
				<div class="width-80 margin-auto">
					<form method="POST" action="<?=url_location;?>api/customer_login/signup.php">
						<input type="hidden" name="sign_up_token" value="<?=$_SESSION['sign_up_token'];?>">
						<div><input type="email" name="email" placeholder="Email" class="input transparent border-all-1" required /></div><br />

						<div><input type="password" name="password" placeholder="Password" class="input transparent border-all-1" required /></div><br />

						<div><input type="password" name="confirm" placeholder="Confirm Password" class="input transparent border-all-1" required /></div><br />

						<div><input type="submit" name="sign_up" value="join now" class="transparent uppercase border-all-1 deep-grey-text width-100 font-allerBd"></div>
					</form>
				</div>
			</div>
		</div>

		<!-- break -->
		<div class="width-100 height-5"></div>
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

<?php 
}else{header('Location: ../index.php');} 
?>