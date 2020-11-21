<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

$data['CPF_USUARIO'] = limparCaracteres($data['CPF_USUARIO']);

$PDO = db_connect();
$sql = "INSERT INTO USUARIOS (CPF_USUARIO, NOME_USUARIO, EMAIL_USUARIO, EMPRESA_USUARIO, DEPARTAMENTO_USUARIO, CARGO_USUARIO, CADASTRO_USUARIO)
        VALUES(:CPF_USUARIO, :NOME_USUARIO, :EMAIL_USUARIO, :EMPRESA_USUARIO, :DEPARTAMENTO_USUARIO, :CARGO_USUARIO, CURRENT_TIMESTAMP)";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':CPF_USUARIO', $data['CPF_USUARIO'], PDO::PARAM_STR);
$stmt->bindParam(':NOME_USUARIO', $data['NOME_USUARIO']);
$stmt->bindParam(':EMAIL_USUARIO', $data['EMAIL_USUARIO']);
$stmt->bindParam(':EMPRESA_USUARIO', $data['EMPRESA_USUARIO']);
$stmt->bindParam(':DEPARTAMENTO_USUARIO', $data['DEPARTAMENTO_USUARIO']);
$stmt->bindParam(':CARGO_USUARIO', $data['CARGO_USUARIO']);

try {
    $stmt->execute();
    header("location: /admin/usuarios/?status=201");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro ao cadastrar usuário: " . $e->getMessage());
}

?>