<?php

include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$empresa = $_POST['empresa'] ?: null;

if (empty($empresa)) {
    header("location: /admin/usuarios/?status=2");
    exit();
}

$PDO = db_connect();
$sql = "INSERT INTO EMPRESAS (NOME_EMPRESA, CADASTRO_EMPRESA)
        VALUES(:NOME_EMPRESA, CURRENT_TIMESTAMP)";

$request = $PDO->prepare($sql);
$request->bindParam(':NOME_EMPRESA', $empresa);

if ($request->execute()) {
    header("location: /admin/empresas/?status=1");
    exit();
} else {
    header("location: /admin/empresas/?status=2");
    exit();
}
