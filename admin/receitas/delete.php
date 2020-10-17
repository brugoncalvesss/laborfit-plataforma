<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$idReceita = isset($_GET['id']) ? $_GET['id'] : null;

if (!$idReceita) {
    die('Erro: Nenhuma informação enviada.');
}

$sql = "DELETE FROM RECEITAS WHERE ID_RECEITA = :ID_RECEITA";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_RECEITA', $idReceita);

if ($stmt->execute()) {
    header("location: /admin/receitas/?status=201");
    exit;
} else {
    die("Erro ao deletar receita.");
}