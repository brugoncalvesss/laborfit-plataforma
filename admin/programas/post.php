<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php';

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

$data['VIMEO_PROGRAMA'] = getVimeoId($data['VIMEO_PROGRAMA']);

$sql = "INSERT INTO
            PROGRAMAS (NOME_PROGRAMA, DIAS_PROGRAMA, VIMEO_PROGRAMA, DESCRICAO_PROGRAMA)
        VALUES
            (:NOME_PROGRAMA, :DIAS_PROGRAMA, :VIMEO_PROGRAMA, :DESCRICAO_PROGRAMA)";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_PROGRAMA', $data['NOME_PROGRAMA']);
$stmt->bindParam(':DIAS_PROGRAMA', $data['DIAS_PROGRAMA']);
$stmt->bindParam(':VIMEO_PROGRAMA', $data['VIMEO_PROGRAMA']);
$stmt->bindParam(':DESCRICAO_PROGRAMA', $data['DESCRICAO_PROGRAMA']);
$stmt->execute();
$idPrograma = $PDO->lastInsertId();

if ($idPrograma) {
    $dia = 1;
    while ($dia <= $data['DIAS_PROGRAMA']) {
        $nomePadrao = 'Dia ' . str_pad($dia, 2, '0', STR_PAD_LEFT);
        $sql = "INSERT INTO ETAPAS (FK_PROGRAMA, NOME_ETAPA) VALUES (:FK_PROGRAMA, :NOME_ETAPA)";
        $stmt = $PDO->prepare($sql);
        $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
        $stmt->bindValue(':NOME_ETAPA', $nomePadrao);
        $stmt->execute();
        $dia++;
    }
}

header("location: /admin/programas/index.php?status=201");
exit;

function getVimeoId($link = null) {

    if (!$link) {
        return null;
    }

    $partVideo = explode('vimeo.com/', $link);
    $idVideo = $partVideo[1] ?: null;

    return $idVideo;
}