<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = $_GET['id'] ?: null;
$idEmpresa = $_GET['empresa'] ?: null;

if (empty($id)) {
    die("Erro: #ID do banner não encontrado.");
}

$PDO = db_connect();
$sql = "DELETE FROM
            BANNERS
        WHERE
            ID_BANNER = :ID_BANNER";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_BANNER', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header("location: /admin/banners/?status=200");
    exit();
} else {
    header("location: /admin/banners/?status=500");
    exit();
}
?>