<?php
session_start();
require_once './functions.php';

if (empty($_SESSION['USUARIO_ID'])) {
    header("location: /programa.php?status=nosession");
    exit;
}

if (empty($_GET['etapa'])) {
    header("location: /programa.php?status=step");
    exit;
}

$idUsuario = $_SESSION['USUARIO_ID'];
$idPrograma = $_GET['programa'];
$etapa = $_GET['etapa'];

$PDO = db_connect();
$sql = "SELECT * FROM PROGRESSO_USUARIO
        WHERE PROGRESSO_USUARIO.FK_USUARIO = :FK_USUARIO AND PROGRESSO_USUARIO.FK_PROGRAMA = :FK_PROGRAMA
        ORDER BY PROGRESSO_USUARIO.ID_PROGRESSO ASC";

$stmt = $PDO->prepare($sql);
$stmt->bindValue(':FK_USUARIO', $idUsuario);
$stmt->bindValue(':FK_PROGRAMA', $idPrograma);
$stmt->execute();
$result = current($stmt->fetchAll(PDO::FETCH_ASSOC));

if (empty($result)) {

    $sql = "INSERT INTO PROGRESSO_USUARIO
            (FK_ETAPA, FK_PROGRAMA, FK_USUARIO)
            VALUES (:FK_ETAPA, :FK_PROGRAMA, :FK_USUARIO)";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_ETAPA', $etapa);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->bindValue(':FK_USUARIO', $idUsuario);
    $stmt->execute();
    $idProgresso = $PDO->lastInsertId();

    $sql = "SELECT * FROM PROGRESSO_USUARIO
            WHERE PROGRESSO_USUARIO.ID_PROGRESSO = :ID_PROGRESSO
            LIMIT 1";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':ID_PROGRESSO', $idProgresso);
    $stmt->execute();
    $result = current($stmt->fetchAll(PDO::FETCH_ASSOC));
}

$redirect = '/programa.php?programa='.$result['FK_PROGRAMA'].'&etapa='.$result['FK_ETAPA'].'&show=1';

header('Location: '. $redirect);
die();
?>
