<?php  
session_start();
session_regenerate_id(true);

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){
?>

<?php include "includes/head.php"; ?>

<?php include "includes/nav.php"; ?>

<?php include "includes/section_nav.php"; ?>

<div class="width-100 height-80 light-yellow-bg flex-column justify-content-center align-items-center font-allerRg">
	<div class="width-70 width-s-100 margin-auto center-text">
		<div class="uppercase font-40 font-s-20 bold-text">welcome to the front page section</div>
		<div class="margin-top-10">Please go through each section to edit the front page of your website</div>
		<div class="margin-top-10">Please follow the side map to understand how to navigate each section</div>
		<div class="margin-top-10">Should you encounter any issue, please feel free to contact us via email to resolve the issue for you or give you the necessary assistance to make your webpage look great</div>
		<div class="margin-top-10">Should you desire your <span class="white-text">personalized e-commerce website</span>, please contact us via email</div>
		<div class="uppercase bold-text font-40 margin-top-10 blue-text">happy selling!</div>
	</div>
</div>

<?php include "includes/footer.php"; ?>

<?php }else{header('Location: ../admin/');} ?>