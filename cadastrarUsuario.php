<?php
$_header = './_header.php';
include($_header);

$cpf = $_POST['cpf'] ?: null;
$nome = $_POST['nome'] ?: null;
$email = $_POST['email'] ?: null;
$password = $_POST['password'] ?: null;

if (empty($cpf) || empty($nome) || empty($email) || empty($password)) {
    die("Erro ao cadastrar.");
}

$PDO = db_connect();

$sql = "SELECT EMPRESA_USUARIO FROM USUARIOS WHERE CPF_USUARIO = :CPF_USUARIO";
$request = $PDO->prepare($sql);
$request->bindParam(':CPF_USUARIO', $cpf, PDO::PARAM_INT);
$request->execute();
$usuario = $request->fetch(PDO::FETCH_ASSOC);

if ($usuario < 1) {
    header("location: /login.php?status=erro");
    exit();
}

$sql = "UPDATE USUARIOS
        SET NOME_USUARIO = :NOME_USUARIO, EMAIL_USUARIO = :EMAIL_USUARIO, SENHA_USUARIO = :SENHA_USUARIO, STATUS_USUARIO = 1, ATUALIZACAO_USUARIO = CURRENT_TIMESTAMP
        WHERE CPF_USUARIO = :CPF_USUARIO";

$request = $PDO->prepare($sql);
$request->bindParam(':CPF_USUARIO', $cpf);
$request->bindParam(':NOME_USUARIO', $nome);
$request->bindParam(':EMAIL_USUARIO', $email);
$request->bindParam(':SENHA_USUARIO', md5($password));

if ($request->execute()) {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['empresa'] = $usuario['EMPRESA_USUARIO'];

    header("location: /?status=".md5($usuario['EMPRESA_USUARIO']));
    exit();
} else {
    header("location: /login.php?status=erro");
    exit();
}

$_footer = './_footer.php';
include($_footer);
