<?php
	session_start();
	if(@empty($_SESSION['usuario'])){
	header("location: login.php");
	}

?>
