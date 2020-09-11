<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

if (!$data['id']) {
    die('Erro: #ID do banner não informado.');
}

if ($_FILES["arquivo"]["name"]) {
    $imagem = uploadFile($_FILES);
} else {
    $imagem = $data['imagem'];
}

$PDO = db_connect();
$sql = "UPDATE BANNERS
        SET IMG_BANNER = :IMG_BANNER, EMPRESA_BANNER = :EMPRESA_BANNER, LINK_BANNER = :LINK_BANNER
        WHERE ID_BANNER = :ID_BANNER";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':IMG_BANNER', $imagem);
$stmt->bindParam(':EMPRESA_BANNER', $data['empresa']);
$stmt->bindParam(':LINK_BANNER', $data['link']);
$stmt->bindParam(':ID_BANNER', $data['id'], PDO::PARAM_INT);

try{
    $stmt->execute();
    $idEmpresa = $data['empresa'];
    header("Location: /admin/banners/lista.php?id=${idEmpresa}&status=201");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro ao cadastrar banner: " . $e->getMessage());
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
