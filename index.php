<?php
require_once "_session.php";
if(@empty($_SESSION['usuario'])){
	header("location: login.php");
}else{
	header("location: dashboard.php");
}
?>
