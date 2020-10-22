<?php
require('./functions.php');

$cpf = $_POST['cpf'] ?: null;
$nascimento = $_POST['nascimento'] ?: null;
$email = $_POST['email'] ?: null;
$password = $_POST['password'] ?: null;
$_POST['APELIDO_USUARIO'] = $_POST['APELIDO_USUARIO'] ?: null;
$_POST['SEXO_USUARIO'] = $_POST['SEXO_USUARIO'] ?: null;

if (empty($cpf) || empty($email) || empty($password)) {
    die("Erro ao cadastrar.");
}

if ($nascimento) {
    $parts = explode('/', $nascimento);
    $nascimento = "$parts[2]-$parts[0]-$parts[1]";
}

$password = md5($password);

$PDO = db_connect();

$sql = "SELECT EMPRESA_USUARIO FROM USUARIOS WHERE CPF_USUARIO = :CPF_USUARIO";
$request = $PDO->prepare($sql);
$request->bindParam(':CPF_USUARIO', $cpf);
$request->execute();
$usuario = $request->fetch(PDO::FETCH_ASSOC);

if ($usuario < 1) {
    header("location: /login.php?status=erro");
    exit();
}

$sql = "UPDATE USUARIOS
        SET APELIDO_USUARIO = :APELIDO_USUARIO,
            DT_NASCIMENTO_USUARIO = :DT_NASCIMENTO_USUARIO,
            SEXO_USUARIO = :SEXO_USUARIO,
            EMAIL_USUARIO = :EMAIL_USUARIO,
            SENHA_USUARIO = :SENHA_USUARIO,
            STATUS_USUARIO = 1,
            ATUALIZACAO_USUARIO = CURRENT_TIMESTAMP
        WHERE CPF_USUARIO = :CPF_USUARIO";

$request = $PDO->prepare($sql);
$request->bindParam(':CPF_USUARIO', $cpf);
$request->bindParam(':APELIDO_USUARIO', $_POST['APELIDO_USUARIO']);
$request->bindParam(':DT_NASCIMENTO_USUARIO', $nascimento);
$request->bindParam(':SEXO_USUARIO', $_POST['SEXO_USUARIO']);
$request->bindParam(':EMAIL_USUARIO', $email);
$request->bindParam(':SENHA_USUARIO', $password);

if ($request->execute()) {

    setcookie("LEMBRAR_USUARIO", true,  time()+86400);
    setcookie("USUARIO_EMPRESA", $usuario['EMPRESA_USUARIO']);
    setcookie("USUARIO_NOME", $nome);

    header('Location: /?status=200');
    exit();
} else {
    header("Location: /login.php?status=erro1");
    exit();
}

$_footer = './_footer.php';
include($_footer);
?>