<?php
require_once '../base/include_top.php';

if(!isset($_SESSION['admin'])) {
	header("Location: ../index.php?error=".urlencode("Admin permission required"));
	exit;
}	
$error = null;

if(isset($_POST['editor1']) && isset($_POST['title'])) {
	try {
		$p = new Posts("../base/");
		$p->setData($_POST['editor1']);
		$p->setTitle($_POST['title']);
		$p->save();
	}
	catch(Exception $e) {
		$error = $e->getMessage();
	}
}
else {
	$error = "Data didnot reach the server";
	header("Location: ../panel.php?error=".urlencode($error));
	exit;
}

if($error != null)
	header("Location: ../panel.php?error=".urlencode($error));
else
	header("Location: ../panel.php?success=true");
?>