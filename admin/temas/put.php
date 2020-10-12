<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Tema não informado.');
}

$sql = "UPDATE TEMAS
        SET NOME_TEMA = :NOME_TEMA, DESCRICAO_TEMA = :DESCRICAO_TEMA
        WHERE ID_TEMA = :ID_TEMA";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_TEMA', $data['NOME_TEMA']);
$stmt->bindParam(':DESCRICAO_TEMA', $data['DESCRICAO_TEMA']);
$stmt->bindParam(':ID_TEMA', $data['ID_TEMA'], PDO::PARAM_INT);

try {
    $stmt->execute();
    header("location: /admin/temas/?status=201");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro salvar tema: " . $e->getMessage());
}