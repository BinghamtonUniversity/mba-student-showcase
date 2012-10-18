<?php
require_once '../base/include_top.php';

if(!isset($_SESSION['admin'])) {
	header("Location: ../index.php?error=".urlencode("Admin permission required"));
	exit;
}	
$error = null;

if(isset($_GET['user'])) { 
	$usrId = intval($_GET['user']);
	try {
		$admin = new Student(array($usrId));
		
		
		try {
			$tmp = new ResumeInfo(array($usrId));
			$tmp->markForDeletion();
		}
		catch (Exception $e) {
			//ignore as row not found
			//echo $e->getMessage();
			//exit;
		}

		StudentExpertise::deleteExpertiseForSid($usrId);

		$admin->markForDeletion(); // but obj not destroyed till we end

		if(unlink("../resume-pdfs/".$usrId.".pdf") !== true)
			throw new Exception("Error deleting the file! You may have to delete it manually at resume-pdfs/".$usrId.".pdf", 1);

		
		header("Location: ../student.php");
		exit;
	}
	catch(Exception $e) {
		header("Location: ../student.php?error=".urlencode($e->getMessage()));
		exit;
	}
}
echo "Something went wrong!"; exit;
?>