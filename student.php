<?php 
include_once('base/include_top.php');
if(!isset($_SESSION['admin'])) {
	header("Location: index.php?error=".urlencode("Admin permission required"));
	exit;
}
?>
<html>
<head>
<?php include_once('headers.php'); ?>
</head>

<body>
<?php include_once('top.php'); ?>

<div id="wrapper">
	<?php include_once('leftbar.php'); ?>
	<div id="rightContent">
	<h3>Admins</h3>
	<?php if(isset($_GET['error'])) { ?>}
	<div class="gagal">
		 <?php echo $_GET['error']; ?>
	</div>
	<?php } ?>
		<tbody>
			<table class="data">
				<tr class="data">
					<th class="data" width="30px">Del</th>
					<th class="data">Username</th>
					<th class="data">Description</th>
					<th class="data">Status</th>
				</tr>
				<?php $stds = Student::ALlStudents(true);
						foreach($stds as $a) {
							?>
				<tr class="data">
					<td class="data" width="30px"><a href="services/deleteStudent.php?user=<?=urlencode($a->getUserID())?>">X</a></td>
					<td class="data"><?=$a->getName();?></td>
					<td class="data"><?=$a->getDescription();?></td>
					<td class="data"><?php if($a->getDescription() == Student::STATUS_PUBLISHED) echo "Published";
										elseif($a->getDescription() == Student::STATUS_NOT_PUBLISHED) echo "Draft";
										else echo "error!";?></td>
				</tr>

				<?php
				}
				?>
			</table>
		</tbody>
	</div>
<?php include_once('footer.php'); ?>
</div>
</body>
</html>