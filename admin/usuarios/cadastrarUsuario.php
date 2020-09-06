<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$cpf = limparCaracteres($_POST['cpf']);
$empresa = $_POST['empresa'] ?: null;

if (empty($cpf) || empty($empresa)) {
    header("location: /admin/usuarios/?status=500");
    exit();
}

$PDO = db_connect();
$sql = "INSERT INTO USUARIOS (CPF_USUARIO, EMPRESA_USUARIO, CADASTRO_USUARIO)
        VALUES(:CPF_USUARIO, :EMPRESA_USUARIO, CURRENT_TIMESTAMP)";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':CPF_USUARIO', $cpf);
$stmt->bindParam(':EMPRESA_USUARIO', $empresa);

try {
    $stmt->execute();
    header("location: /admin/usuarios/?status=201");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro ao cadastrar usuário: " . $e->getMessage());
}

?>