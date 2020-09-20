<?php
require('./functions.php');

$cpf = (limparCaracteres($_POST['cpf'])) ?: null;
$password = ($_POST['password']) ?: null;

$PDO = db_connect();

$sql = "SELECT * FROM
            USUARIOS
        LEFT JOIN EMPRESAS ON
            USUARIOS.EMPRESA_USUARIO = EMPRESAS.ID_EMPRESA
        WHERE
            CPF_USUARIO = :CPF_USUARIO
            AND SENHA_USUARIO = :SENHA_USUARIO
        LIMIT 1";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':CPF_USUARIO', $cpf);
$stmt->bindParam(':SENHA_USUARIO', md5($password));
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    session_start();

    $_SESSION['EMPRESA_USUARIO'] = $usuario['EMPRESA_USUARIO'];
    $_SESSION['NOME_EMPRESA'] = $usuario['NOME_EMPRESA'];
    $_SESSION['NOME_USUARIO'] = $usuario['NOME_USUARIO'];

    header('Location: /?status=200');
    exit();
} else {
    header("Location: /login.php?status=500");
    exit();
}