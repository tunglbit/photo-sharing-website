<?php
	session_start();
	unset($_SESSION['accountEmail']);
	header("Location: index.php");
?>
