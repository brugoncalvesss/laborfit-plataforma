<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    header("location: /admin/login/index.php");
    exit();
}

if (empty($data['email'])) {
    die('Erro: Não foi informado o e-mail.');
}

if (empty($data['password'])) {
    die('Erro: Não foi informado a senha.');
}

$PDO = db_connect();
$sql = "SELECT * FROM
            ADMINS
        LEFT JOIN EMPRESAS ON
            ADMINS.EMPRESA_ADMIN = EMPRESAS.ID_EMPRESA
        WHERE
            ADMINS.EMAIL_ADMIN = :EMAIL_ADMIN 
            AND ADMINS.SENHA_ADMIN = :SENHA_ADMIN
        LIMIT 1";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':EMAIL_ADMIN', $data['email']);
$stmt->bindParam(':SENHA_ADMIN', md5($data['password']));
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    session_start();

    $_SESSION['ID_EMPRESA'] = $usuario['ID_EMPRESA'];
    $_SESSION['NOME_EMPRESA'] = $usuario['NOME_EMPRESA'];
    $_SESSION['EMAIL'] = $usuario['EMAIL_ADMIN'];
    $_SESSION['SUPER_ADMIN'] = $usuario['SUPER_ADMIN'];

    header("location: /admin/paginas/?status=200");
    exit();
} else {
    header("Location: /admin/login/?status=500");
    exit();
}
