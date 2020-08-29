<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

if (empty($_POST)) {
    die("Erro: Nenhuma informação enviada.");
}

$nome = $_POST['nome'] ?: null;
$link = $_POST['link'] ?: null;
$thumb = $_POST['thumb'] ?: null;
$categoria = $_POST['categoria'] ?: null;
$idEmpresa = $_POST['empresa'] ?: null;

if (empty($idEmpresa)) {
    die("Erro: Empresa não informada.");
}

$PDO = db_connect();
$sql = "SELECT ID_VIDEO FROM VIDEOS WHERE EMPRESA_VIDEO = :EMPRESA_VIDEO";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':EMPRESA_VIDEO', $idEmpresa, PDO::PARAM_INT);

try{
    $stmt->execute();
    $video = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    throw new Exception("Erro ao carregar empresa: " . $e->getMessage());
}

if ($video['ID_VIDEO']) {
    $sql = "UPDATE VIDEOS
            SET NOME_VIDEO = :NOME_VIDEO, LINK_VIDEO = :LINK_VIDEO, THUMB_VIDEO = :THUMB_VIDEO,
                CATEGORIA_VIDEO = :CATEGORIA_VIDEO, EMPRESA_VIDEO = :EMPRESA_VIDEO
            WHERE ID_VIDEO = :ID_VIDEO";
} else {
    $sql = "INSERT INTO VIDEOS (NOME_VIDEO, LINK_VIDEO, THUMB_VIDEO, CATEGORIA_VIDEO, EMPRESA_VIDEO, CADASTRO_VIDEO)
    VALUES(:NOME_VIDEO, :LINK_VIDEO, :THUMB_VIDEO, :CATEGORIA_VIDEO, :EMPRESA_VIDEO, CURRENT_TIMESTAMP)";
}

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_VIDEO', $nome);
$stmt->bindParam(':LINK_VIDEO', $link);
$stmt->bindParam(':THUMB_VIDEO', $thumb);
$stmt->bindParam(':CATEGORIA_VIDEO', $categoria);
$stmt->bindParam(':EMPRESA_VIDEO', $idEmpresa);
if ($video['ID_VIDEO']) {
    $stmt->bindParam(':ID_VIDEO', $video['ID_VIDEO'], PDO::PARAM_INT);
}

try {
    $stmt->execute();
    header("location: /admin/paginas/videos.php?id=${idEmpresa}&status=200");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro salvar página: " . $e->getMessage());
}
