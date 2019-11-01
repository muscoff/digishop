<?php  
	session_start();
	session_regenerate_id(true);
	
	include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
	include $_SERVER['DOCUMENT_ROOT']."/digishop/models/User.php";

	//initialize db
	$DBH = new DB();
	$db = $DBH->connect();

	//Initialize Users
	$user = new User($db);

	$msg = null;
?>

<?php include 'includes/head.php'; ?>

<?php  
	if(isset($_POST['submit'])){
		$password = $_POST['password'];
		
		//initialize password for db execution
		$user->password = $password;
		if($user->verify()){
			$rand = rand(1, 10000);
			$_SESSION['admin_id'] = $rand;
			header('Location: dashboard.php');
			exit();
		}else{
			$msg = 'Failed';
		}
	}
?>

<div class="width-100 height-80 flex-column justify-content-center align-items-center">
	<div class="width-30 width-s-100 width-m-80 height-30 padding-all-10">
		<form method="POST">
			<div><input type="password" class="input" name="password" placeholder="Password"></div><br />
			<div class="display-<?=((!empty($msg))?'block':'none');?>">
				<div class="red-text font-allerBd"><?=$msg;?></div><br />
			</div>
			<input type="submit" class="width-100 deep-grey-bg white-text font-allerBd" name="submit" value="Login">
		</form>
	</div>
</div>

<?php include 'includes/footer.php'; ?>