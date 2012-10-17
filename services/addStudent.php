<?php
require_once '../base/include_top.php';
if(!isset($_SESSION['admin'])) {
	header("Location: ../index.php?error=".urlencode("Admin permission required"));
	exit;
}	
$error = null;

if(isset($_POST['user']) && isset ($_POST['desc']) && isset ($_FILES['resume']) && isset($_POST['status'])) {
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
		$stud->setStatus(intval($_POST['status']));
		Student::checkResumeValidity($resume);
		$stud->insert();
		try {
			$stud->updateResumeInfo($resume,"../");
		}
		catch(Exception $e) {
			$stud->markForDeletion();
			throw $e;
			
		}
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
echo $error;
header ("Location: ../addStudent.php?error=".urlencode($error));
?>