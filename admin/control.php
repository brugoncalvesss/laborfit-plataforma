<?php
session_start();

if (!isset($_SESSION['nome'])) {
	header("location: /admin/login/?status=301");
	exit;
}
?>