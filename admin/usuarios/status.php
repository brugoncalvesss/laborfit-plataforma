<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$id = $_GET['id'] ?: null;

if (empty($id)) {
    die('Erro: Usuário não encontrado.');
}

$PDO = db_connect();

$sql = "SELECT STATUS_USUARIO FROM USUARIOS WHERE ID_USUARIO = :ID_USUARIO LIMIT 1";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_USUARIO', $id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (empty($result)) {
    header("location: /admin/usuarios/?status=500");
    exit;
}

$status = !intval($result['STATUS_USUARIO']);

$PDO = db_connect();
$sql = "UPDATE USUARIOS
        SET STATUS_USUARIO = :STATUS_USUARIO
        WHERE ID_USUARIO = :ID_USUARIO";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':STATUS_USUARIO', $status);
$stmt->bindParam(':ID_USUARIO', $id, PDO::PARAM_INT);
$stmt->execute();

header("location: /admin/usuarios/editar.php?id=" .$id);
exit;