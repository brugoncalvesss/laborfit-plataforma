<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = $_GET['id'] ?: null;

if (empty($id)) {
    die("Erro: #ID do vídeo não encontrado.");
}

$PDO = db_connect();
$sql = "DELETE FROM
            VIDEOS
        WHERE
            ID_VIDEO = :ID_VIDEO";

$request = $PDO->prepare($sql);
$request->bindParam(':ID_VIDEO', $id, PDO::PARAM_INT);

if ($request->execute()) {
    header("location: /admin/paginas/?status=200");
    exit();
} else {
    header("location: /admin/paginas/?status=500");
    exit();
}
