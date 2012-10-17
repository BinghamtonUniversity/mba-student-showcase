<?php
require_once '../base/include_top.php';
if(!isset($_SESSION['admin'])) {
	header("Location: ../index.php?error=".urlencode("Admin permission required"));
	exit;
}	
$error = null;

if(isset($_POST['user']) && isset ($_POST['desc']) && isset ($_FILES['resume'])) {
	$name = trim($_POST['user']);
	$desc = trim($_POST['desc']);
	$resume = $_FILES['resume'];
	try {
		
		$stud = new Student();
		$stud->setName($name);
		$stud->setDescription($desc);
		if(isset($_POST['url']) && strlen(trim($_POST['url'])) > 0 ) {
			$stud->setURL(trim($_POST['url']));
		}
		if(!Student::checkResumeValidity($resume)) throw new Exception("Wrong resume format", 1);
		
		$stud->insert();
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
echo $error;
header ("Location: ../addStudent.php?error=".urlencode($error));
?>