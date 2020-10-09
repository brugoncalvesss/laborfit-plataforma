<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

$sql = "DELETE FROM DESTAQUES_VIDEOS WHERE ID_DESTAQUE = :ID_DESTAQUE";
$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_DESTAQUE', $data['ID_DESTAQUE'], PDO::PARAM_INT);
$stmt->execute();

$sql = "INSERT INTO
            DESTAQUES_VIDEOS (ID_DESTAQUE, ID_VIDEO, DATA_EXIBICAO)
        VALUES
            (:ID_DESTAQUE, :ID_VIDEO, :DATA_EXIBICAO)";
$PDO = db_connect();
$stmt = $PDO->prepare($sql);

$date = date("Y-m-d");

foreach ($data['ID_VIDEO'] as $key => $idVideo) {
    $stmt->bindParam(':ID_DESTAQUE', $data['ID_DESTAQUE'], PDO::PARAM_INT);
    $stmt->bindParam(':ID_VIDEO', $idVideo, PDO::PARAM_INT);
    $stmt->bindParam(':DATA_EXIBICAO', $date);
    $stmt->execute();
    $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
}

try {
    header("location: /admin/destaques/ordem.php?status=201&id=".$data['ID_DESTAQUE']);
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro salvar tema: " . $e->getMessage());
}