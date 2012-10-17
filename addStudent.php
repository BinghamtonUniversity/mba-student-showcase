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
	<?php if(isset($_GET['error'])) { ?>}
	<div class="gagal">
		 <?php echo $_GET['error']; ?>
	</div>
	<?php } ?>
		
	<div class="headLoginForm">
	Add Student
	</div>
	<div class="fieldLogin">
	<form method="POST" action="services/addStudent.php" enctype="multipart/form-data">
	<label>Name(1-999 charecters)</label><br>
	<input name="user" id="user" type="text" class="login" value="<?php if(isset($_GET['user'])) echo $_GET['user']; ?>"><br>
	<label>Description(1-999 charecters)</label><br>
	<textarea rows="20" cols="50" name="desc" id="desc"><?php if(isset($_GET['desc'])) echo $_GET['desc']; ?></textarea><br>
	<label for="file">Resume(PDF Format):</label>
	<input type="file" name="resume" id="resume" /> <br>
	<label>Link to web-resume</label>
	<input name="url" id="url" type="text" class="login" value="<?php if(isset($_GET['url'])) echo $_GET['url']; ?>"><br>
	<select name="status">
  		<option selected="selected" value="<?=Student::STATUS_NOT_PUBLISHED?>">Draft</option>
  		<option value="<?=Student::STATUS_PUBLISHED?>">Publish</option>
	</select><br>
	<input type="submit" class="button" value="Add Student" />
	</form>
	</div>
	</div>
<?php include_once('footer.php'); ?>
</div>
</body>
</html>