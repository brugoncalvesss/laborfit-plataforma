<?php

include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = $_GET['id'] ?: null;

if (empty($id)) {
    header("location: /admin/usuarios/?status=1");
    exit();
}

$PDO = db_connect();

$sql = "DELETE FROM USUARIOS WHERE ID_USUARIO = :ID_USUARIO";

$request = $PDO->prepare($sql);
$request->bindParam(':ID_USUARIO', $id, PDO::PARAM_INT);

if ($request->execute()) {
    header("location: /admin/usuarios/?status=3");
    exit();
} else {
    header("location: /admin/usuarios/?status=2");
    exit();
}
