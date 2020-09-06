<?php
session_start();

if (!isset($_SESSION['empresa'])) {
	header("location: /login.php?status=301");
	exit;
}
?>