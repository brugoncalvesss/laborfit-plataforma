<?php

include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$cpf = limparCaracteres($_POST['cpf']);
$nome = $_POST['nome'] ?: null;
$email = $_POST['email'] ?: null;
$empresa = $_POST['empresa'] ?: null;

if (empty($cpf) || empty($empresa)) {
    header("location: /admin/usuarios/?status=1");
    exit();
}

$PDO = db_connect();
$sql = "INSERT INTO USUARIOS (NOME_USUARIO, CPF_USUARIO, EMAIL_USUARIO, EMPRESA_USUARIO, CADASTRO_USUARIO)
        VALUES(:NOME_USUARIO, :CPF_USUARIO, :EMAIL_USUARIO, :EMPRESA_USUARIO, CURRENT_TIMESTAMP)";

$request = $PDO->prepare($sql);
$request->bindParam(':NOME_USUARIO', $nome);
$request->bindParam(':CPF_USUARIO', $cpf);
$request->bindParam(':EMAIL_USUARIO', $email);
$request->bindParam(':EMPRESA_USUARIO', $empresa);

if ($request->execute()) {
    header("location: /admin/usuarios/?status=3");
    exit();
} else {
    header("location: /admin/usuarios/?status=2");
    exit();
}

function limparCaracteres($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}