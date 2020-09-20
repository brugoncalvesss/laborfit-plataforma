<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Tema não informado.');
}


$sql = "INSERT INTO
            TEMAS (NOME_TEMA, EMPRESA_TEMA)
        VALUES
            (:NOME_TEMA, :EMPRESA_TEMA)";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_TEMA', $data['NOME_TEMA']);
$stmt->bindParam(':EMPRESA_TEMA', $_SESSION['ID_EMPRESA'], PDO::PARAM_INT);

try {
    $stmt->execute();
    header("location: /admin/temas/?status=201");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro salvar tema: " . $e->getMessage());
}