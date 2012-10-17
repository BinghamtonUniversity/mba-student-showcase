<?php
require_once '../base/include_top.php';
if(!isset($_SESSION['admin'])) {
	header("Location: ../index.php?error=".urlencode("Admin permission required"));
	exit;
}	

$error = null;
if( isset ($_FILES['resume']) && isset($_POST['uid'])) {
	$resume = $_FILES['resume'];
	try {
		$stud = new Student(array(intval($_POST['uid'])));
		Student::checkResumeValidity($resume);
		$stud->updateResumeInfo($resume,"../");
		//success
		header('Location: ../student.php');
		exit;
	}
	catch(Exception $e) {
		$error = $e->getMessage();
	}
}
else {
	$error = "Some data has not reached us.";
}
//echo $error;
if(isset($_POST['uid']))
header ("Location: ../editStudent.php?id=".$_POST['uid']."&error=".urlencode($error));
else
header ("Location: ../student.php?error=".urlencode($error));
?>