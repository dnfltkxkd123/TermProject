<?php
	require('tools.php');
	session_start();
	unset($_SESSION['id'],$_SESSION['nickname']);
	//header('Location : main_page.php');
	logOut();
?>