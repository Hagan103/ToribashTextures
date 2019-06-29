<?php
	include 'includes/session.php';
	if(isset($_SESSION['Email'])||isset($_SESSION['Username']) ){
		
	unset($_SESSION['Email']);
	unset($_SESSION['Username']);

	session_destroy();
	header("Location: index.php");

   	exit;
	}
?>
