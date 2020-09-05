<?php
session_start();

if (!isset($_SESSION['empresa']) || $_SESSION['empresa'] != '') {
	header("location: /login.php");
	exit;
}
?>