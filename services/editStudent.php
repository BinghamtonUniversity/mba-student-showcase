<?php
require_once '../base/include_top.php';
if(!isset($_SESSION['admin'])) {
	header("Location: ../index.php?error=".urlencode("Admin permission required"));
	exit;
}	
$error = null;
var_dump($_POST);
if(isset($_POST['user']) && isset ($_POST['desc']) && isset($_POST['status']) && isset($_POST['uid'])) {
	$name = trim($_POST['user']);
	$desc = trim($_POST['desc']);
	try {
		
		$stud = new Student(array(intval($_POST['uid'])));
		$stud->setName($name);
		$stud->setDescription($desc);
		if(isset($_POST['url'])) {
			$stud->setURL(trim($_POST['url']));
		}
		$stud->setStatus(intval($_POST['status']));
		
		$stud->save();
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