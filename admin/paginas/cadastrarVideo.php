<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

if ($data['link']) {
    $data['link'] = getVimeoId($data['link']);
}

if (!empty($_FILES['arquivo']['name'])) {
    $imagem = uploadFile($_FILES);
} else {
    $imagem = null;
}

$sql = "INSERT INTO
            VIDEOS (NOME_VIDEO, LINK_VIDEO, THUMB_VIDEO, EMPRESA_VIDEO, DESC_VIDEO, ALBUM_VIDEO, CADASTRO_VIDEO)
        VALUES
            (:NOME_VIDEO, :LINK_VIDEO, :THUMB_VIDEO, :EMPRESA_VIDEO, :DESC_VIDEO, :ALBUM_VIDEO, CURRENT_TIMESTAMP)";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_VIDEO', $data['nome']);
$stmt->bindParam(':LINK_VIDEO', $data['link']);
$stmt->bindParam(':THUMB_VIDEO', $imagem);
$stmt->bindParam(':EMPRESA_VIDEO', $_SESSION['ID_EMPRESA']);
$stmt->bindParam(':DESC_VIDEO', $data['descricao']);
$stmt->bindParam(':ALBUM_VIDEO', $data['album']);

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
