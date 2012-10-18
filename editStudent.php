<?php 
include_once('base/include_top.php');
if(!isset($_SESSION['admin'])) {
	header("Location: index.php?error=".urlencode("Admin permission required"));
	exit;
}
if(!isset($_GET['id']))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}
try {
	$stud = new Student(array(intval($_GET['id'])));
}
catch(Exception $e) {
	header("HTTP/1.0 404 Not Found");
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
	Edit Student: Change the required feilds.
	</div>
	<div class="fieldLogin">
	<form method="POST" action="services/editStudent.php">
	<label>Name(1-999 charecters)</label><br>
	<input name="user" id="user" type="text" class="login" value="<?=$stud->getName()?>"><br>
	<label>Description(1-999 charecters)</label><br>
	<textarea rows="20" cols="50" name="desc" id="desc"><?=$stud->getDescription()?></textarea><br>
	
	<label>Link to web-resume</label>
	<input name="url" id="url" type="text" class="login" value="<?=$stud->getURL()?>"><br>
	<select name="status">
  		<option <?php if($stud->getStatus() == Student::STATUS_NOT_PUBLISHED) { ?> selected="selected" <?php } ?> value="<?=Student::STATUS_NOT_PUBLISHED?>">Draft</option>
  		<option <?php if($stud->getStatus() == Student::STATUS_PUBLISHED) { ?> selected="selected" <?php } ?> value="<?=Student::STATUS_PUBLISHED?>">Publish</option>
	</select><br>

	<label>Student Tags</label><br>
	<select name="tags[]" id="tags[]" multiple="multiple">
		<?php
		$expertises = StudentExpertise::getExpertises($stud->getUserID());
		foreach (Expertise::AllTags() as $key => $value) {
			$selected = null;
			foreach ($expertises as $exp) {
				if($exp->getTag() == $value->getTag()) {
					$selected = " selected=\"selected\" ";
					break;
				}
			}
			echo '<option '.$selected.' value="'.$value->getTag().'">'.$value->getTag().'</option>';
		}
  		?>
	</select><br>

	<input type="hidden" name="uid" id="uid" value="<?=$stud->getUserID()?>">
	<input type="submit" class="button" value="Edit Student" />
	</form>
	*************<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OR<br>
	*************<br>
	<form method="POST" action="services/editResume.php" enctype="multipart/form-data">
		<input type="hidden" name="uid" id="uid" value="<?=$stud->getUserID()?>">
		<label for="file">Resume(PDF Format):<a href="resume-pdfs/<?=$stud->getUserID();?>.pdf"><img src="mos-css/img/pdf-icon.png" width="20px;" height="20px;"/></a></label>
		<input type="file" name="resume" id="resume" /> <br>
		<input type="submit" class="button" value="Upload Resume" />
	</form>
	</div>
	</div>
<?php include_once('footer.php'); ?>
</div>
</body>
</html>