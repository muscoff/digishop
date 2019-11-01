<?php  
session_start();

include $_SERVER['DOCUMENT_ROOT']."/digishop/db/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/digishop/models/CustomerAccount.php";

// Initialize db
$DBH = new DB();
$db = $DBH->connect();

// Initialize Customer Account
$account = new CustomerAccount($db);

// get url
$url = $_SERVER['HTTP_REFERER'];
$explode = explode('?', $url);
$url = $explode[0];

// Get Host and url link from where post request is coming from
$HOST = $_SERVER['HTTP_HOST'];
$referer = null;

if(isset($_SERVER['HTTP_REFERER'])){
	$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
}

// compare to see if the url to which the post request is coming is same with our host
if($HOST == $referer){
	if(isset($_POST['account_token'])){
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$address = $_POST['address'];
		$town = $_POST['town'];
		$state = $_POST['state'];
		$postal_code = $_POST['postal_code'];
		$country = $_POST['country'];
		$email = $_POST['email'];
		$number = $_POST['number'];
		$account_token = $_POST['account_token'];

		$input = [$first_name, $last_name, $address, $town, $state, $postal_code, $email, $number, $account_token];

		if(in_array('', $input)){
			$msg = 'Please fill in all the input fields. Happy Setting up your account!!!';
			header('Location: '.$url."?msg=".$msg);
		}
		else{

			//Initialize for db
			$account->first_name = $first_name;
			$account->last_name = $last_name;
			$account->address = $address;
			$account->town = $town;
			$account->state = $state;
			$account->postal_code = $postal_code;
			$account->country = $country;
			$account->email = $email;
			$account->number = $number;


			if($account_token == $_SESSION['account_token']){
				//initialize for db

				if($account->create()){
					$_SESSION['details']['first_name'] = $first_name;
					$_SESSION['details']['last_name'] = $last_name;
					$_SESSION['details']['address'] = $address;
					$_SESSION['details']['town'] = $town;
					$_SESSION['details']['state'] = $state;
					$_SESSION['details']['postal_code'] = $postal_code;
					$_SESSION['details']['country'] = $country;
					$_SESSION['details']['email'] = $email;
					$_SESSION['details']['number'] = $number;

					//Get id of the last inserted data and assign to session
					$getData = $account->fetch_single();

					$_SESSION['details']['id'] = $getData['id'];

					$msg = 'success';
					header('Location: '.$url."?msg=".$msg);
				}else{
					$msg = 'Failed to insert details';
					header('Location: '.$url."?msg=".$msg);
				}
			}else{
				die('.... Don\'t think it.....');
			}
		}
	}else{
		die(); //End of check if account token is set -- kill the page
	}
}else{
	die('.....Don\'t try it....');
}

?>