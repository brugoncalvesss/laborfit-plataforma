<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$categoria = $_POST['categoria'] ?: null;

if (empty($categoria)) {
    die('Erro: Categoria não informada.');
}

$PDO = db_connect();
$sql = "INSERT INTO CATEGORIAS (NOME_CATEGORIA) VALUES (:NOME_CATEGORIA)";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_CATEGORIA', $categoria);

try{
    $stmt->execute();
    header("location: /admin/categorias/?status=200");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro ao cadastrar categoria: " . $e->getMessage());
}
