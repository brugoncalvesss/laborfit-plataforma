<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php';

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

$data['FL_PREMIO_ETAPA'] = ($data['FL_PREMIO_ETAPA']) ? 1 : 0;

if (!$data['FL_PREMIO_ETAPA']) {
    $data['ICON_ETAPA'] = null;
    $data['POPUP_ETAPA'] = null;
}

if ($data['FL_PREMIO_ETAPA'] && !empty($_FILES['ICON_ETAPA']['name'])) {
    $data['ICON_ETAPA'] = uploadFile($_FILES);
}

if ($data['FL_PREMIO_ETAPA'] && !empty($_FILES['POPUP_ETAPA']['name'])) {
    $data['POPUP_ETAPA'] = uploadFile($_FILES);
}

$PDO = db_connect();
$sql = "UPDATE ETAPAS
        SET NOME_ETAPA = :NOME_ETAPA, FL_PREMIO_ETAPA = :FL_PREMIO_ETAPA, ICON_ETAPA = :ICON_ETAPA, POPUP_ETAPA = :POPUP_ETAPA
        WHERE ID_ETAPA = :ID_ETAPA AND FK_PROGRAMA = :FK_PROGRAMA";

$stmt = $PDO->prepare($sql);
$stmt->bindValue(':NOME_ETAPA', $data['NOME_ETAPA']);
$stmt->bindValue(':FL_PREMIO_ETAPA', $data['FL_PREMIO_ETAPA']);
$stmt->bindValue(':ICON_ETAPA', $data['ICON_ETAPA']);
$stmt->bindValue(':POPUP_ETAPA', $data['POPUP_ETAPA']);
$stmt->bindValue(':ID_ETAPA', $data['ID_ETAPA']);
$stmt->bindValue(':FK_PROGRAMA', $data['FK_PROGRAMA']);
$stmt->execute();

header("Location: /admin/etapas/?id=".$data['FK_PROGRAMA']);
exit();

function uploadFile($file) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
    
    $temp = explode(".", $file["arquivo"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);

    $target_file = $target_dir . basename($newfilename);

    $result = move_uploaded_file($file['arquivo']['tmp_name'], $target_file);

    if (!$result) {
        $newfilename = 'Error: file upload';
    }

    return $newfilename;
}