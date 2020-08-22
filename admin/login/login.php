<?php

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email) && empty($password)) {
    header("location: /admin/login/index.php");
    exit();
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['nome'] = $email;
$_SESSION['id_empresa'] = session_create_id();

header("location: /admin/empresas/");
exit();