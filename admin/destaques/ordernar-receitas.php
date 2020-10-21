<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$ordem = json_decode($_POST['data']);

$sql = "UPDATE RECEITAS
        SET
            EXIBICAO_RECEITA = :EXIBICAO_RECEITA
        WHERE 
            ID_RECEITA = :ID_RECEITA";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);

$date = date("Y-m-d");

foreach ($ordem as $idReceita) {
    $idReceita = (int)$idReceita;
    $stmt->bindParam(':ID_RECEITA', $idReceita);
    $stmt->bindParam(':EXIBICAO_RECEITA', $date);
    $stmt->execute();
    $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
}

try {
    echo "OK";
} catch(PDOException $e) {
    throw new Exception("Erro ao salvar: " . $e->getMessage());
}