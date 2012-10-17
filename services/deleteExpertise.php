<?php
require_once '../base/include_top.php';

if(!isset($_SESSION['admin'])) {
	header("Location: ../index.php?error=".urlencode("Admin permission required"));
	exit;
}	
$error = null;

if(isset($_GET['tag'])) {
	try {
		$e = new Expertise(array($_GET['tag']));
		StudentExpertise::deleteExpertise($_GET['tag']);
		$e->markForDeletion();
		$e = null; //destroy object
		header("Location: ../tags.php");;
		exit;
	}
	catch(Exception $e) {
		header("Location: ../tags.php?error=".urlencode($e->getMessage()));
		exit;
	}
}
echo "Something went wrong!"; exit;
?>