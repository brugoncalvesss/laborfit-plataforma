<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$idDestaque = (int)$_POST['id'];
$ordem = json_decode($_POST['data']);

$sql = "UPDATE
            DESTAQUES_VIDEOS
        SET
            DATA_EXIBICAO = :DATA_EXIBICAO
        WHERE 
            ID_DESTAQUE = :ID_DESTAQUE
            AND ID_VIDEO = :ID_VIDEO";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);

$date = date("Y-m-d");

foreach ($ordem as $idVideo) {
    $idVideo = (int)$idVideo;
    $stmt->bindParam(':ID_DESTAQUE', $idDestaque);
    $stmt->bindParam(':ID_VIDEO', $idVideo);
    $stmt->bindParam(':DATA_EXIBICAO', $date);
    $stmt->execute();
    $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
}

try {
    echo "OK";
} catch(PDOException $e) {
    throw new Exception("Erro ao salvar: " . $e->getMessage());
}