<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php';

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

$data['VIMEO_PROGRAMA'] = getVimeoId($data['VIMEO_PROGRAMA']);

$sql = "UPDATE PROGRAMAS
        SET NOME_PROGRAMA = :NOME_PROGRAMA, VIMEO_PROGRAMA = :VIMEO_PROGRAMA, DESCRICAO_PROGRAMA = :DESCRICAO_PROGRAMA
        WHERE ID_PROGRAMA = :ID_PROGRAMA";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindValue(':NOME_PROGRAMA', $data['NOME_PROGRAMA']);
$stmt->bindValue(':VIMEO_PROGRAMA', $data['VIMEO_PROGRAMA']);
$stmt->bindValue(':DESCRICAO_PROGRAMA', $data['DESCRICAO_PROGRAMA']);
$stmt->bindValue(':ID_PROGRAMA', $data['ID_PROGRAMA']);
$stmt->execute();

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