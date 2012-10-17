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
					<th class="data">Tag</th>
				</tr>
				<?php $tags = Expertise::AllTags(); 
						foreach($tags as $a) {
							?>
				<tr class="data">
					<td class="data" width="30px"><a href="services/deleteExpertise.php?tag=<?=urlencode($a->getTag())?>">X</a></td>
					<td class="data"><?=$a->getTag();?></td>
				</tr>

				<?php
				}
				?>
			</table>
		</tbody>
		<div id="loginForm">
	<div class="headLoginForm">
	Add Tags
	</div>
	<div class="fieldLogin">
	<form method="POST" action="services/addExpertise.php">
	<label>Tag</label><br>
	<input name="tag" id="tag" type="text" class="login" value="<?php if(isset($_GET['tag'])) echo $_GET['tag']; ?>"><br>
	<input type="submit" class="button" value="Add Tag">
	</form>
	</div>
</div>
	</div>
<?php include_once('footer.php'); ?>
</div>
</body>
</html>