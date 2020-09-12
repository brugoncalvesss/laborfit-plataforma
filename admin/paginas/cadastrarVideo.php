<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

if (empty($data['empresa'])) {
    die("Erro: Empresa não informada.");
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
            VIDEOS (NOME_VIDEO, LINK_VIDEO, THUMB_VIDEO, CATEGORIA_VIDEO, EMPRESA_VIDEO, DESC_VIDEO, CADASTRO_VIDEO)
        VALUES
            (:NOME_VIDEO, :LINK_VIDEO, :THUMB_VIDEO, :CATEGORIA_VIDEO, :EMPRESA_VIDEO, :DESC_VIDEO, CURRENT_TIMESTAMP)";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_VIDEO', $data['nome']);
$stmt->bindParam(':LINK_VIDEO', $data['link']);
$stmt->bindParam(':THUMB_VIDEO', $imagem);
$stmt->bindParam(':CATEGORIA_VIDEO', $data['categoria']);
$stmt->bindParam(':EMPRESA_VIDEO', $data['empresa']);
$stmt->bindParam(':DESC_VIDEO', $data['descricao']);

try {
    $stmt->execute();
    $idEmpresa = $data['empresa'];
    header("location: /admin/paginas/lista.php?id=${idEmpresa}&status=201");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro salvar página: " . $e->getMessage());
}

function getYoutubeId(string $link) {

    $partVideo = explode('?v=', $link);
    $idVideo = $partVideo[1] ?: '000001';

    return $idVideo;
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

function getVideoId(int $id) {
    $PDO = db_connect();
    $sql = "SELECT ID_VIDEO FROM VIDEOS WHERE EMPRESA_VIDEO = :EMPRESA_VIDEO";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':EMPRESA_VIDEO', $id, PDO::PARAM_INT);
    
    try{
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar empresa: " . $e->getMessage());
    }

    return $result;
}
