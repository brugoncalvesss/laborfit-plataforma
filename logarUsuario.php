<?php
require('./functions.php');

$cpf = (limparCaracteres($_POST['cpf'])) ?: null;
$password = ($_POST['password']) ?: null;

$PDO = db_connect();

$sql = "SELECT EMPRESA_USUARIO, NOME_USUARIO FROM USUARIOS WHERE CPF_USUARIO = :CPF_USUARIO AND SENHA_USUARIO = :SENHA_USUARIO";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':CPF_USUARIO', $cpf);
$stmt->bindParam(':SENHA_USUARIO', md5($password));
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    session_start();

    $_SESSION['empresa'] = $usuario['EMPRESA_USUARIO'];
    $_SESSION['usuario'] = $usuario['NOME_USUARIO'];

    header('Location: /?status=200');
    exit();
} else {
    header("Location: /login.php?status=500");
    exit();
}