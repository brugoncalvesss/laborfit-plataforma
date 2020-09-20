<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Dados não informadados.');
}

$PDO = db_connect();
$sql = "INSERT INTO
            ADMINS (EMAIL_ADMIN, SENHA_ADMIN, EMPRESA_ADMIN)
        VALUES (:EMAIL_ADMIN, :SENHA_ADMIN, :EMPRESA_ADMIN)";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':EMAIL_ADMIN', $data['email']);
$stmt->bindParam(':SENHA_ADMIN', md5($data['password']));
$stmt->bindParam(':EMPRESA_ADMIN', $_SESSION['ID_EMPRESA']);

try{
    $stmt->execute();
    header("location: /admin/administradores/?status=200");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro ao cadastrar administrador: " . $e->getMessage());
}
