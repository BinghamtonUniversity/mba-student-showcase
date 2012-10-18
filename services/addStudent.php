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

		if(isset($_POST['tags'])) { 
			try {
				if(is_array($_POST['tags']))
					StudentExpertise::setExpertises($stud->getUserID(),$_POST['tags']);
				else
					StudentExpertise::setExpertises($stud->getUserID(),array($_POST['tags']));
			}
			catch(Exception $e) {
				//clean up the mess left
				try {
					$tmp = new ResumeInfo(array($stud->getUserID()));
					$tmp->markForDeletion();
				}
				catch(Exception $e) {
					//this means that there was no entry into the resume so ignore it
				}
				
				$stud->markForDeletion();
				throw $e;
			}

		}
//exit;
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