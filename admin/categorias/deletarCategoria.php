<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = $_GET['id'] ?: null;

if (empty($id)) {
    die("Erro: #ID da categoria não encontrado.");
}

$PDO = db_connect();
$sql = "DELETE FROM
            CATEGORIAS
        WHERE
            ID_CATEGORIA = :ID_CATEGORIA";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_CATEGORIA', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header("location: /admin/categorias/status=200");
    exit();
} else {
    header("location: /admin/categorias/status=500");
    exit();
}
