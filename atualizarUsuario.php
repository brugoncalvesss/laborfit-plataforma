<?php
require_once './functions.php';

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro ao atualizar senha.');
}

$PDO = db_connect();
$sql = "UPDATE
            USUARIOS
        SET
            USUARIOS.SENHA_USUARIO = :SENHA_USUARIO, USUARIOS.ATUALIZACAO_USUARIO = CURRENT_TIMESTAMP
        WHERE
            USUARIOS.CPF_USUARIO = :CPF_USUARIO
        LIMIT 1";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':SENHA_USUARIO', md5($data['SENHA_USUARIO']));
$stmt->bindParam(':CPF_USUARIO', $data['CPF_USUARIO']);

try{
    $stmt->execute();
    header('Location: /senha-alterada.php?status=200');
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro ao atualizar usuário: " . $e->getMessage());
}

