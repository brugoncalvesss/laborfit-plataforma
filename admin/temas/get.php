<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$PDO = db_connect();
$sql = "SELECT ID_TEMA, NOME_TEMA FROM TEMAS ORDER BY TEMAS.NOME_TEMA ASC";
$stmt = $PDO->prepare($sql);
$stmt->execute();
$arResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

$temas = [];
foreach ($arResult as $key => $result) {
    $temas[] = $result['NOME_TEMA'];
}

header('Content-Type: application/json');
echo json_encode($temas);
exit;