<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

if (!$data['id']) {
    die('Erro: #ID do vídeo não informado.');
}

if ($data['link']) {
    $data['link'] = getVimeoId($data['link']);
}

if ($_FILES["arquivo"]["name"]) {
    $imagem = uploadFile($_FILES);
} else {
    $imagem = $data['imagem'];
}

$PDO = db_connect();
$sql = "UPDATE
            VIDEOS
        SET
            NOME_VIDEO = :NOME_VIDEO, LINK_VIDEO = :LINK_VIDEO, THUMB_VIDEO = :THUMB_VIDEO, DESC_VIDEO = :DESC_VIDEO, ALBUM_VIDEO = :ALBUM_VIDEO, TEMA_VIDEO = :TEMA_VIDEO, DESTAQUE_VIDEO = :DESTAQUE_VIDEO, INTRO_VIDEO = :INTRO_VIDEO
        WHERE
            ID_VIDEO = :ID_VIDEO";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_VIDEO', $data['nome']);
$stmt->bindParam(':LINK_VIDEO', $data['link']);
$stmt->bindParam(':THUMB_VIDEO', $imagem);
$stmt->bindParam(':DESC_VIDEO', $data['descricao']);
$stmt->bindParam(':ALBUM_VIDEO', $data['album']);
$stmt->bindParam(':TEMA_VIDEO', $data['TEMA_VIDEO']);
$stmt->bindParam(':DESTAQUE_VIDEO', $data['DESTAQUE_VIDEO']);
$stmt->bindParam(':INTRO_VIDEO', $data['INTRO_VIDEO']);
$stmt->bindParam(':ID_VIDEO', $data['id'], PDO::PARAM_INT);

try{
    $stmt->execute();
    header("Location: /admin/paginas/?status=201");
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

function getVimeoId(string $link) {

    $partVideo = explode('vimeo.com/', $link);
    $idVideo = $partVideo[1] ?: '000000001';

    return $idVideo;
}