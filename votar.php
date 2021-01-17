<?php
session_start();
require_once './functions.php';

$idUsuario = $_GET['usuario'];
$idAula = $_GET['aula'];
$nmVoto = $_GET['voto'];
$urlReferencia = base64_decode($_GET['referencia']);

$PDO = db_connect();
$sql = "SELECT NM_LIKE FROM LIKE_AULA WHERE FK_USUARIO = :FK_USUARIO AND FK_AULA = :FK_AULA";

$stmt = $PDO->prepare($sql);
$stmt->bindValue(':FK_USUARIO', $idUsuario);
$stmt->bindValue(':FK_AULA', $idAula);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($result)) {

    $sql = "INSERT INTO LIKE_AULA (NM_LIKE, FK_USUARIO, FK_AULA) VALUES (:NM_LIKE, :FK_USUARIO, :FK_AULA)";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':NM_LIKE', $nmVoto);
    $stmt->bindValue(':FK_USUARIO', $idUsuario);
    $stmt->bindValue(':FK_AULA', $idAula);
    $stmt->execute();
}

if (!empty($result)) {

    $sql = "UPDATE LIKE_AULA SET NM_LIKE = :NM_LIKE WHERE FK_USUARIO = :FK_USUARIO AND FK_AULA = :FK_AULA";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':NM_LIKE', $nmVoto);
    $stmt->bindValue(':FK_USUARIO', $idUsuario);
    $stmt->bindValue(':FK_AULA', $idAula);
    $stmt->execute();
}

header('Location: '. $urlReferencia);
die();
?>
