<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

if ($_FILES["arquivo"]["name"]) {
    $imagem = uploadFile($_FILES);
} else {
    $imagem = $data['IMG_RECEITA'];
}

$sql = "UPDATE RECEITAS
        SET NOME_RECEITA = :NOME_RECEITA, DESCRICAO_RECEITA = :DESCRICAO_RECEITA, IMG_RECEITA = :IMG_RECEITA
        WHERE ID_RECEITA = :ID_RECEITA";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_RECEITA', $data['NOME_RECEITA']);
$stmt->bindParam(':DESCRICAO_RECEITA', $data['DESCRICAO_RECEITA']);
$stmt->bindParam(':ID_RECEITA', $data['ID_RECEITA']);
$stmt->bindParam(':IMG_RECEITA', $imagem);

if ($stmt->execute()) {
    header("location: /admin/receitas/?status=201");
    exit;
} else {
    die("Erro ao atualizar receita.");
}

function uploadFile($file) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
     
    $temp = explode(".", $file["arquivo"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);

    $target_file = $target_dir . basename($newfilename);

    $result = move_uploaded_file($file['arquivo']['tmp_name'], $target_file);

    if (!$result) {
        $newfilename = 'error: upload file';
    }

    return $newfilename;
}