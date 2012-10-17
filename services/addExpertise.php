<?php
require_once '../base/include_top.php';
if(!isset($_SESSION['admin'])) {
	header("Location: ../index.php?error=".urlencode("Admin permission required"));
	exit;
}	

$error = null;

if(isset($_POST['tag'])) {
	try {
		$e = new Expertise();
		$e->setTag($_POST['tag']);
		$e->insert();

		header('Location: ../tags.php');
		exit;
	}
	catch(Exception $e) {
		$error = $e->getMessage();
		if($error == "The insertion failed!")
			$error = "Tag already exist";
	}
}
else {
	$error = "Tag has not reached us.";
}
header ("Location: ../tags.php?error=".urlencode($error));
?>