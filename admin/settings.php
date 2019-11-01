<?php  
session_start();
session_regenerate_id(true);

if(isset($_SESSION['admin_id']) & !empty($_SESSION['admin_id'])){

?>

<?php include 'includes/head.php'; ?>

<?php include 'includes/nav.php'; ?>

<?php  

$data = json_decode(file_get_contents(url_location.'api/control/fetch.php'),true);

$msg = isset($_GET['msg'])?$_GET['msg']:null;

?>

<!-- break -->
<div class="width-100 height-10 flex-column justify-content-center align-items-center font-allerRg">
	<?=$msg;?>
</div>

<div class="width-40 width-s-100 width-m-90 margin-auto">
	<div>
		<form method="POST" enctype="multipart/form-data" action="<?=url_location;?>api/control/<?=((!empty($data))?'edit':'create');?>.php">
			<?php if(!empty($data)): ?>
				<input type="hidden" name="id" value="<?=$data['id'];?>">
			<?php endif; ?>

			<div class="font-allerBd uppercase"><?=((!empty($data))?'Change':'Upload');?> Logo</div>
			<div><input type="file" name="image" class="input"></div><br />
			<input type="submit" name="" class="deep-grey-bg white-text font-allerBd" value="<?=((!empty($data))?'Edit':'Upload');?> Logo">
		</form>
	</div> <br />

	<div class="display-<?=((!empty($data))?'none':'block');?> font-allerBd capitalize green-text">
		Please upload your logo to enable the visibility of the section control. Thank you!
	</div>

	<div class="display-<?=((!empty($data))?'block':'none');?>">
		<div class="margin-top-10">
			<table class="table bordered highlight">
				<thead>
					<tr class="font-allerBd uppercase"><th>section name</th><th>visibility</th></tr>
				</thead>
				<tbody class="bordered">
					<tr class="capitalize font-allerRg">
						<td>section 1</td>
						<td>
							<a href="<?=url_location;?>api/control/update_one.php?id=<?=$data['id'];?>&first=<?=((!empty($data['first_sec']) & $data['first_sec'] == 1)?0:1);?>">
								<span class="<?=((!empty($data) & $data['first_sec'] == 1)?'blue':'red');?>-bg white-text padding-all-5"><?=((!empty($data) & $data['first_sec'] == 1)?'On':'Off');?></span>
							</a>
						</td>
					</tr>
					<tr class="capitalize font-allerRg">
						<td>section 2</td>
						<td>
							<a href="<?=url_location;?>api/control/update_two.php?id=<?=$data['id'];?>&second=<?=((!empty($data['second_sec']) & $data['second_sec'] == 1)?0:1);?>">
								<span class="<?=((!empty($data) & $data['second_sec'] == 1)?'blue':'red');?>-bg white-text padding-all-5"><?=((!empty($data) & $data['second_sec'] == 1)?'On':'Off');?></span>
							</a>
						</td>
					</tr>
					<tr class="capitalize font-allerRg">
						<td>section 3</td>
						<td>
							<a href="<?=url_location;?>api/control/update_three.php?id=<?=$data['id'];?>&third=<?=((!empty($data['third_sec']) & $data['third_sec'] == 1)?0:1);?>">
								<span class="<?=((!empty($data) & $data['third_sec'] == 1)?'blue':'red');?>-bg white-text padding-all-5"><?=((!empty($data) & $data['third_sec'] == 1)?'On':'Off');?></span>
							</a>
						</td>
					</tr>
					<tr class="capitalize font-allerRg">
						<td>section 4</td>
						<td>
							<a href="<?=url_location;?>api/control/update_four.php?id=<?=$data['id'];?>&fourth=<?=((!empty($data['fourth_sec']) & $data['fourth_sec'] == 1)?0:1);?>">
								<span class="<?=((!empty($data) & $data['fourth_sec'] == 1)?'blue':'red');?>-bg white-text padding-all-5"><?=((!empty($data) & $data['fourth_sec'] == 1)?'On':'Off');?></span>
							</a>
						</td>
					</tr>
					<tr class="capitalize font-allerRg">
						<td>section 5</td>
						<td>
							<a href="<?=url_location;?>api/control/update_five.php?id=<?=$data['id'];?>&fifth=<?=((!empty($data['fifth_sec']) & $data['fifth_sec'] == 1)?0:1);?>">
								<span class="<?=((!empty($data) & $data['fifth_sec'] == 1)?'blue':'red');?>-bg white-text padding-all-5"><?=((!empty($data) & $data['fifth_sec'] == 1)?'On':'Off');?></span>
							</a>
						</td>
					</tr>
					<tr class="capitalize font-allerRg">
						<td>section 6</td>
						<td>
							<a href="<?=url_location;?>api/control/update_six.php?id=<?=$data['id'];?>&sixth=<?=((!empty($data['sixth_sec']) & $data['sixth_sec'] == 1)?0:1);?>">
								<span class="<?=((!empty($data) & $data['sixth_sec'] == 1)?'blue':'red');?>-bg white-text padding-all-5"><?=((!empty($data) & $data['sixth_sec'] == 1)?'On':'Off');?></span>
							</a>
						</td>
					</tr>
					<tr class="capitalize font-allerRg">
						<td>section 7</td>
						<td>
							<a href="<?=url_location;?>api/control/update_seven.php?id=<?=$data['id'];?>&seventh=<?=((!empty($data['seventh_sec']) & $data['seventh_sec'] == 1)?0:1);?>">
								<span class="<?=((!empty($data) & $data['seventh_sec'] == 1)?'blue':'red');?>-bg white-text padding-all-5"><?=((!empty($data) & $data['seventh_sec'] == 1)?'On':'Off');?></span>
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- break -->
<div class="width-100 height-10"></div>

<?php include 'includes/footer.php'; ?>

<?php }else{header('Location: ../admin/');} ?>