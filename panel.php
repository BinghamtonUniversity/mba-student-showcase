<?php 
include_once('base/include_top.php');
if(!isset($_SESSION['admin'])) {
	header("Location: index.php?error=".urlencode("Admin permission required"));
	exit;
}

$post = new Posts("base/");
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
	<?php if(isset($_GET['error'])) { ?>}
	<div class="gagal">
		 <?php echo $_GET['error']; ?>
	</div>
	<?php } ?>

	<h3>Enter the new post:</h3>
	<form action="services/editPost.php" method="POST">

		<lable> <b>Title:</b> </lable>
		<input name="title" type="text" class="sedang" value="<?=$post->getTitle();?>"/>
		<input name="publish" type="submit" class="button" value="Publish!"/>
		<textarea class="ckeditor" name="editor1"><?=$post->getData();?></textarea>
		<script type="text/javascript">
			CKEDITOR.replace( 'editor1',{
				height: '600px'
			} );
		</script>

		
	</form>
	</div>
<?php include_once('footer.php'); ?>
</div>
</body>
</html>