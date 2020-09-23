<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

$data['DESTAQUE_VIDEO'] = isset($data['DESTAQUE_VIDEO']) ? $data['DESTAQUE_VIDEO'] : 0;

if ($data['LINK_VIDEO']) {
    $data['LINK_VIDEO'] = getVimeoId($data['LINK_VIDEO']);
}

if (!empty($_FILES['arquivo']['name'])) {
    $imagem = uploadFile($_FILES);
} else {
    $imagem = null;
}

$sql = "INSERT INTO
            VIDEOS (NOME_VIDEO, LINK_VIDEO, THUMB_VIDEO, DESC_VIDEO, ALBUM_VIDEO, TEMA_VIDEO, DESTAQUE_VIDEO, INTRO_VIDEO, CADASTRO_VIDEO)
        VALUES
            (:NOME_VIDEO, :LINK_VIDEO, :THUMB_VIDEO, :DESC_VIDEO, :ALBUM_VIDEO, :TEMA_VIDEO, :DESTAQUE_VIDEO, :INTRO_VIDEO, CURRENT_TIMESTAMP)";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_VIDEO', $data['NOME_VIDEO']);
$stmt->bindParam(':LINK_VIDEO', $data['LINK_VIDEO']);
$stmt->bindParam(':THUMB_VIDEO', $imagem);
$stmt->bindParam(':DESC_VIDEO', $data['DESC_VIDEO']);
$stmt->bindParam(':ALBUM_VIDEO', $data['ALBUM_VIDEO']);
$stmt->bindParam(':TEMA_VIDEO', $data['TEMA_VIDEO']);
$stmt->bindParam(':DESTAQUE_VIDEO', $data['DESTAQUE_VIDEO']);
$stmt->bindParam(':INTRO_VIDEO', $data['INTRO_VIDEO']);

try {
    $stmt->execute();
    header("location: /admin/paginas/?status=201");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro salvar página: " . $e->getMessage());
}

function getVimeoId(string $link) {

    $partVideo = explode('vimeo.com/', $link);
    $idVideo = $partVideo[1] ?: '000000001';

    return $idVideo;
}

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
