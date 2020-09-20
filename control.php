<?php
session_start();

if (!isset($_SESSION['EMPRESA_USUARIO'])) {
	header("location: /login.php?status=301");
	exit;
}
?>