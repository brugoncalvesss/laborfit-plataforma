<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

$data['CPF_USUARIO'] = limparCaracteres($data['CPF_USUARIO']);
if ($data['DT_NASCIMENTO_USUARIO']) {
    $parts = explode('/', $data['DT_NASCIMENTO_USUARIO']);
    $data['DT_NASCIMENTO_USUARIO'] = "$parts[2]-$parts[1]-$parts[0]";
}

$PDO = db_connect();
$sql = "UPDATE
            USUARIOS
        SET
            EMPRESA_USUARIO = :EMPRESA_USUARIO,
            DEPARTAMENTO_USUARIO = :DEPARTAMENTO_USUARIO,
            SUBDEPARTAMENTO_USUARIO = :SUBDEPARTAMENTO_USUARIO,
            NOME_USUARIO = :NOME_USUARIO,
            DT_NASCIMENTO_USUARIO = :DT_NASCIMENTO_USUARIO,
            SEXO_USUARIO = :SEXO_USUARIO,
            CPF_USUARIO = :CPF_USUARIO,
            EMAIL_USUARIO = :EMAIL_USUARIO,
            ATUALIZACAO_USUARIO = CURRENT_TIMESTAMP
        WHERE
            ID_USUARIO = :ID_USUARIO";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':EMPRESA_USUARIO', $_SESSION['ID_EMPRESA'], PDO::PARAM_INT);
$stmt->bindParam(':DEPARTAMENTO_USUARIO', $data['DEPARTAMENTO_USUARIO']);
$stmt->bindParam(':SUBDEPARTAMENTO_USUARIO', $data['SUBDEPARTAMENTO_USUARIO']);
$stmt->bindParam(':NOME_USUARIO', $data['NOME_USUARIO']);
$stmt->bindParam(':DT_NASCIMENTO_USUARIO', $data['DT_NASCIMENTO_USUARIO']);
$stmt->bindParam(':SEXO_USUARIO', $data['SEXO_USUARIO']);
$stmt->bindParam(':CPF_USUARIO', $data['CPF_USUARIO']);
$stmt->bindParam(':EMAIL_USUARIO', $data['EMAIL_USUARIO']);
$stmt->bindParam(':ID_USUARIO', $data['ID_USUARIO'], PDO::PARAM_INT);

try{
    $stmt->execute();
    header("location: /admin/usuarios/?status=200");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro salvar usuário: " . $e->getMessage());
}
