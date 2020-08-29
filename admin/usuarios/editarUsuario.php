<?php

include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = $_POST['id'] ?: null;
$cpf = limparCaracteres($_POST['cpf']);
$empresa = $_POST['empresa'] ?: null;
$departamento = $_POST['departamento'] ?: null;
$subdepartamento = $_POST['subdepartamento'] ?: null;
$nome = $_POST['nome'] ?: null;
$nascimento = $_POST['nascimento'] ?: null;
$sexo = $_POST['sexo'] ?: null;
$email = $_POST['email'] ?: null;

if (empty($id) || empty($cpf) || empty($empresa)) {
    header("location: /admin/usuarios/?status=1");
    exit();
}

if ($nascimento) {
    $parts = explode('/', $nascimento);
    $nascimento = "$parts[2]-$parts[1]-$parts[0]";
}

$PDO = db_connect();
$sql = "UPDATE USUARIOS
        SET EMPRESA_USUARIO = :EMPRESA_USUARIO, DEPARTAMENTO_USUARIO = :DEPARTAMENTO_USUARIO,
            SUBDEPARTAMENTO_USUARIO = :SUBDEPARTAMENTO_USUARIO, NOME_USUARIO = :NOME_USUARIO,
            DT_NASCIMENTO_USUARIO = :DT_NASCIMENTO_USUARIO, SEXO_USUARIO = :SEXO_USUARIO
            CPF_USUARIO = :CPF_USUARIO, EMAIL_USUARIO = :EMAIL_USUARIO,
            ATUALIZACAO_USUARIO = CURRENT_TIMESTAMP
        WHERE ID_USUARIO = :ID_USUARIO";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':EMPRESA_USUARIO', $empresa);
$stmt->bindParam(':DEPARTAMENTO_USUARIO', $departamento);
$stmt->bindParam(':SUBDEPARTAMENTO_USUARIO', $subdepartamento);
$stmt->bindParam(':NOME_USUARIO', $nome);
$stmt->bindParam(':DT_NASCIMENTO_USUARIO', $nascimento);
$stmt->bindParam(':SEXO_USUARIO', $sexo);
$stmt->bindParam(':CPF_USUARIO', $cpf);
$stmt->bindParam(':EMAIL_USUARIO', $email);
$stmt->bindParam(':ID_USUARIO', $id, PDO::PARAM_INT);

try{
    $stmt->execute();
    header("location: /admin/usuarios/?status=success");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro salvar usuário: " . $e->getMessage());
}
