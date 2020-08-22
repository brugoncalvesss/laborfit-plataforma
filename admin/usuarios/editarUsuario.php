<?php

include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = $_POST['id'] ?: null;
$cpf = limparCaracteres($_POST['cpf']);
$nome = $_POST['nome'] ?: null;
$email = $_POST['email'] ?: null;
$empresa = $_POST['empresa'] ?: null;

if (empty($id) || empty($cpf) || empty($empresa)) {
    header("location: /admin/usuarios/?status=1");
    exit();
}

$PDO = db_connect();
$sql = "UPDATE USUARIOS
        SET NOME_USUARIO = :NOME_USUARIO, CPF_USUARIO = :CPF_USUARIO, EMAIL_USUARIO = :EMAIL_USUARIO, EMPRESA_USUARIO = :EMPRESA_USUARIO, ATUALIZACAO_USUARIO = CURRENT_TIMESTAMP
        WHERE ID_USUARIO = :ID_USUARIO";

$request = $PDO->prepare($sql);
$request->bindParam(':ID_USUARIO', $id, PDO::PARAM_INT);
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