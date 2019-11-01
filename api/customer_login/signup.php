<?php  
session_start();

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/CustomerLogin.php";

// Initialize db
$DBH = new DB();
$db = $DBH->connect();

// Initialize Customer Login
$customer = new CustomerLogin($db);

// get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

// Get Host 
$HOST = $_SERVER['HTTP_HOST'];
$referer = null;

if(isset($_SERVER['HTTP_REFERER'])){
	$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
}

if($HOST == $referer){
	if(isset($_POST['sign_up_token'])){
		$token = $_POST['sign_up_token'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];

		if($password == $confirm){
			if($token == $_SESSION['sign_up_token']){
				if($password == $confirm){
					//prepare email and password for db check 
					$customer->email = $email;
					$customer->password = $password;

					// Check if email already exist in database
					if($customer->read_single()){
						$msg = 'Email already exist! Please change and provide valid email address to proceed!';
						header('Location: '.$url."?msg=".$msg);
					}else{
						if($customer->create()){
							$msg = 'Account created';
							header('Location: '.$url.'?msg='.$msg);
						}else{
							$msg = 'Failed';
							header('Location: '.$url."?msg=".$msg);
						}
					}
				}
			}else{
				die();
			}
		}else{
			$msg = 'Password not matching..';
			header('Location: '.$url."?msg=".$msg);
		}
	}else{
		die();
	}
}else{
	die();
}


?>