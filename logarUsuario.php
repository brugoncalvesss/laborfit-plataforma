<?php
require('./_header.php');

$cpf = (limparCaracteres($_POST['cpf'])) ?: null;
$password = ($_POST['password']) ?: null;

$PDO = db_connect();

$sql = "SELECT EMPRESA_USUARIO, NOME_USUARIO FROM USUARIOS WHERE CPF_USUARIO = :CPF_USUARIO AND SENHA_USUARIO = :SENHA_USUARIO";
$request = $PDO->prepare($sql);
$request->bindParam(':CPF_USUARIO', $cpf, PDO::PARAM_INT);
$request->bindParam(':SENHA_USUARIO', md5($password));
$request->execute();
$usuario = $request->fetch(PDO::FETCH_ASSOC);

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':CPF_USUARIO', $cpf, PDO::PARAM_INT);
$stmt->bindParam(':SENHA_USUARIO', md5($password));
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['empresa'] = $usuario['EMPRESA_USUARIO'];
    $_SESSION['usuario'] = $usuario['NOME_USUARIO'];
    header("location: /?status=200");
    exit();
} else {
    header("location: /login.php?status=500");
    exit();
}