<?php
session_start();

if (!isset($_COOKIE['LEMBRAR_USUARIO'])) {
	unset($_COOKIE['LEMBRAR_USUARIO']);
	unset($_COOKIE['USUARIO_EMPRESA']);
	unset($_COOKIE['USUARIO_NOME']);
	unset($_COOKIE['USUARIO_ID']);
	header("location: /login.php?status=301");
	exit;
}
?>