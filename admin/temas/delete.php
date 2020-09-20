<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = $_GET['id'] ?: null;

if (empty($id)) {
    die("Erro: #ID do tema não encontrado.");
}

$PDO = db_connect();
$sql = "DELETE FROM
            TEMAS
        WHERE
            ID_TEMA = :ID_TEMA";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_TEMA', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header("location: /admin/temas/?status=200");
    exit();
} else {
    header("location: /admin/temas/?status=500");
    exit();
}
?>