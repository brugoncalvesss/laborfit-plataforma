<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$idEmpresa = $_GET['id'] ?: null;

if (empty($idEmpresa)) {
    header("location: /admin/login/logout.php?status=500");
    exit();
}

$PDO = db_connect();
$sql = "SELECT * FROM
            EMPRESAS
        WHERE
            ID_EMPRESA = :ID_EMPRESA
        LIMIT 1";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_EMPRESA', $idEmpresa);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
    
    session_start();

    $_SESSION['ID_EMPRESA'] = $empresa['ID_EMPRESA'];
    $_SESSION['NOME_EMPRESA'] = $empresa['NOME_EMPRESA'];

    header("location: /admin/paginas/?status=200");
    exit();
} else {
    header("location: /admin/login/logout.php?status=301");
    exit();
}