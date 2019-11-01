<?php  
	include $_SERVER['DOCUMENT_ROOT'].'/digishop/definitions/def.php';

	$scriptName = $_SERVER['SCRIPT_NAME'];
	$explodeScript = explode('/', $scriptName);
	$countExplode = count($explodeScript);
	$scriptName = $explodeScript[$countExplode-1];
	$explodeScriptName = explode('.', $scriptName);
	$scriptName = $explodeScriptName[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Levis Mockup</title>
	<link rel="stylesheet" type="text/css" href="<?=url_location;?>css/style.css">
	<?php if($scriptName == 'pay'): ?>
	<link rel="stylesheet" type="text/css" href="<?=url_location;?>css/stripe.css" >
	<?php endif; ?>
</head>
<body>
