<?php  
session_start();
session_regenerate_id(true);

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){
?>

<?php include 'includes/head.php'; ?>

<?php include 'includes/nav.php'; ?>

<div class="font-20 center-text capitalize font-allerBd padding-all-10">Welcome to your dashboard</div>

<?php include 'includes/footer.php'; ?>

<?php }else{header('Location: ../admin/');} ?>