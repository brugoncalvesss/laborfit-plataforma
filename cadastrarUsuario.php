<?php
$_header = './_header.php';
include($_header);

$cpf = $_POST['cpf'] ?: null;
$departamento = $_POST['departamento'] ?: null;
$subdepartamento = $_POST['subdepartamento'] ?: null;
$nome = $_POST['nome'] ?: null;
$nascimento = $_POST['nascimento'] ?: null;
$sexo = $_POST['sexo'] ?: null;
$email = $_POST['email'] ?: null;
$password = $_POST['password'] ?: null;

if (empty($cpf) || empty($nome) || empty($email) || empty($password)) {
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
        SET DEPARTAMENTO_USUARIO = :DEPARTAMENTO_USUARIO, SUBDEPARTAMENTO_USUARIO = :SUBDEPARTAMENTO_USUARIO,
            NOME_USUARIO = :NOME_USUARIO, DT_NASCIMENTO_USUARIO = :DT_NASCIMENTO_USUARIO,
            SEXO_USUARIO = :SEXO_USUARIO, EMAIL_USUARIO = :EMAIL_USUARIO, SENHA_USUARIO = :SENHA_USUARIO,
            STATUS_USUARIO = 1, ATUALIZACAO_USUARIO = CURRENT_TIMESTAMP
        WHERE CPF_USUARIO = :CPF_USUARIO";

$request = $PDO->prepare($sql);
$request->bindParam(':CPF_USUARIO', $cpf);
$request->bindParam(':DEPARTAMENTO_USUARIO', $departamento);
$request->bindParam(':SUBDEPARTAMENTO_USUARIO', $subdepartamento);
$request->bindParam(':NOME_USUARIO', $nome);
$request->bindParam(':DT_NASCIMENTO_USUARIO', $nascimento);
$request->bindParam(':SEXO_USUARIO', $sexo);
$request->bindParam(':EMAIL_USUARIO', $email);
$request->bindParam(':SENHA_USUARIO', $password);

if ($request->execute()) {
    $_SESSION['empresa'] = $usuario['EMPRESA_USUARIO'];
    header("location: /index.php?status=".md5($usuario['EMPRESA_USUARIO']));
    exit;
} else {
    header("location: /login.php?status=erro1");
    exit();
}

$_footer = './_footer.php';
include($_footer);
