<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = $_GET['id'] ?: null;

if (empty($id)) {
    die("Erro: #ID do administrador não encontrado.");
}

$PDO = db_connect();
$sql = "DELETE FROM
            ADMINS
        WHERE
            ID_ADMIN = :ID_ADMIN";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_ADMIN', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header("location: /admin/administradores/?status=200");
    exit();
} else {
    header("location: /admin/administradores/?status=500");
    exit();
}
?>