<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$PDO = db_connect();
$sql = "SELECT ID_CATEGORIA, NOME_CATEGORIA FROM CATEGORIAS ORDER BY CATEGORIAS.NOME_CATEGORIA ASC";
$stmt = $PDO->prepare($sql);
$stmt->execute();
$arResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categorias = [];
foreach ($arResult as $key => $result) {
    $categorias[] = $result['NOME_CATEGORIA'];
}

header('Content-Type: application/json');
echo json_encode($categorias);
exit;