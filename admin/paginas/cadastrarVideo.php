<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

if (empty($_POST)) {
    die("Erro: Nenhuma informação enviada.");
}

$nome = $_POST['nome'] ?: null;
$link = $_POST['link'] ?: null;
$thumb = null;
$categoria = $_POST['categoria'] ?: null;
$idEmpresa = $_POST['empresa'] ?: null;

if (empty($idEmpresa)) {
    die("Erro: Empresa não informada.");
}

if ($link) {
    $link = getYoutubeId($link);
}

if ($_FILES) {
    $thumb = uploadFile($_FILES);
}

$video = getVideoId($idEmpresa);
// $sql = "UPDATE VIDEOS
//             SET NOME_VIDEO = :NOME_VIDEO, LINK_VIDEO = :LINK_VIDEO, THUMB_VIDEO = :THUMB_VIDEO,
//                 CATEGORIA_VIDEO = :CATEGORIA_VIDEO, EMPRESA_VIDEO = :EMPRESA_VIDEO
//             WHERE ID_VIDEO = :ID_VIDEO";

$sql = "INSERT INTO VIDEOS (NOME_VIDEO, LINK_VIDEO, THUMB_VIDEO, CATEGORIA_VIDEO, EMPRESA_VIDEO, CADASTRO_VIDEO)
        VALUES(:NOME_VIDEO, :LINK_VIDEO, :THUMB_VIDEO, :CATEGORIA_VIDEO, :EMPRESA_VIDEO, CURRENT_TIMESTAMP)";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_VIDEO', $nome);
$stmt->bindParam(':LINK_VIDEO', $link);
$stmt->bindParam(':THUMB_VIDEO', $thumb);
$stmt->bindParam(':CATEGORIA_VIDEO', $categoria);
$stmt->bindParam(':EMPRESA_VIDEO', $idEmpresa);

// if ($video['ID_VIDEO']) {
//     $stmt->bindParam(':ID_VIDEO', $video['ID_VIDEO'], PDO::PARAM_INT);
// }

try {
    $stmt->execute();
    header("location: /admin/paginas/videos.php?id=${idEmpresa}&status=201");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro salvar página: " . $e->getMessage());
}

function getYoutubeId(string $link) {

    $partVideo = explode('?v=', $link);
    $idVideo = $partVideo[1] ?: '000001';

    return $idVideo;
}

function uploadFile($file) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
    
    $temp = explode(".", $file["arquivo"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);

    $target_file = $target_dir . basename($newfilename);

    $result = move_uploaded_file($file['arquivo']['tmp_name'], $target_file);

    if (!$result) {
        die("Erro ao enviar arquivo.");
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