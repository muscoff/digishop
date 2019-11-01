<?php  
session_start();
//session_regenerate_id(true);

if(isset($_SESSION['cart']) & !empty($_SESSION['id'])){

?>
	<!-- head -->
	<?php include "includes/head.php"; ?>

	<!-- Get control settings array -->
	<?php  
		$dataControl = json_decode(file_get_contents(url_location.'api/control/fetch.php'),true);

		if(!empty($dataControl)){
	?>

	<!-- top nav -->
	<?php include "includes/topnav.php"; ?>

	<!-- nav -->
	<?php include "includes/nav.php"; ?>

	<!-- <div class="width-100 height-10"></div> -->

	<?php if($dataControl['first_sec'] == 1): ?>

	<!-- first banner  First Section -->
	<?php include "includes/firstbanner.php"; ?>

	<?php endif; ?>

	<?php if($dataControl['second_sec'] == 1): ?>

	<!-- Good things are happening Second Section -->
	<?php include "includes/happening.php"; ?>

	<?php endif; ?>

	<?php if($dataControl['third_sec'] == 1): ?>

	<!-- wear now pay later Third Section -->
	<?php include "includes/paylater.php"; ?>

	<?php endif; ?>

	<?php if($dataControl['fourth_sec'] == 1): ?>

	<!-- three levis models Fourth Section -->
	<?php include "includes/threemodels.php"; ?>

	<?php endif; ?>

	<?php if($dataControl['fifth_sec'] == 1): ?>

	<!-- summer Fifth Section -->
	<?php include "includes/summer.php"; ?>

	<?php endif; ?>

	<?php if($dataControl['sixth_sec'] == 1): ?>

	<!-- shirt Sixth Section -->
	<?php include "includes/shirt.php"; ?>

	<?php endif; ?>

	<?php if($dataControl['seventh_sec'] == 1): ?>

	<!-- off the cuff blog Seventh Section -->
	<?php include "includes/cuff.php"; ?>

	<?php endif; ?>

	<!-- side nav -->
	<?php include "includes/side_nav.php"; ?>

	<!-- footer -->
	<?php include "includes/footer.php"; ?>

	<!-- JS script -->
	<?php include "includes/script.php"; ?>

	<!-- tail -->
	<?php include "includes/tail.php"; ?>

	<?php  }else{ ?> <!-- This is the end for if for checking the control array -->

	<div class="width-100 height-100 flex-column justify-content-center align-items-center">
		<div class="font-20 font-allerRg capitalize">
			Please visit our <a href="<?=url_location;?>product.php" class="blue-text">product</a> section to shop. The frontview shall be ready soon
		</div>
	</div>

	<?php } ?> <!-- This is the end of the else for the control array -->

<?php  
}else{
	header('Location: session.php');
}
?>