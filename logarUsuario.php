<?php
$_header = './_header.php';
include($_header);

$cpf = (limparCaracteres($_POST['cpf'])) ?: null;
$password = ($_POST['password']) ?: null;

$PDO = db_connect();

$sql = "SELECT EMPRESA_USUARIO FROM USUARIOS WHERE CPF_USUARIO = :CPF_USUARIO AND SENHA_USUARIO = :SENHA_USUARIO";
$request = $PDO->prepare($sql);
$request->bindParam(':CPF_USUARIO', $cpf, PDO::PARAM_INT);
$request->bindParam(':SENHA_USUARIO', md5($password));
$request->execute();
$usuario = $request->fetch(PDO::FETCH_ASSOC);

if (!empty($usuario)) {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['empresa'] = $usuario['EMPRESA_USUARIO'];
    header("location: /?status=".md5(date()));
    exit();

} else {
    header("location: /login.php?status=wrong");
    exit();
}
