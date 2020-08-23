<?php

include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = $_POST['id'] ?: null;
$empresa = $_POST['empresa'] ?: null;

if (empty($id) || empty($empresa)) {
    header("Erro: Informe os dados da empresa.");
    exit();
}

$PDO = db_connect();
$sql = "UPDATE EMPRESAS
        SET NOME_EMPRESA = :NOME_EMPRESA
        WHERE ID_EMPRESA = :ID_EMPRESA";

$request = $PDO->prepare($sql);
$request->bindParam(':ID_EMPRESA', $id, PDO::PARAM_INT);
$request->bindParam(':NOME_EMPRESA', $empresa);

if ($request->execute()) {
    header("location: /admin/empresas/?status=".md5($id));
    exit();
} else {
    header("location: /admin/empresas/?status=erro");
    exit();
}
