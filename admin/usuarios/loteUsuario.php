<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

$data['CPF_USUARIO'] = explode(';', $data['CPF_USUARIO']);

foreach ($data['CPF_USUARIO'] as $cpf) {
    if ($cpf) {
        $cpfUsuario = limparCaracteres($cpf);
    
        $PDO = db_connect();
        $sql = "INSERT INTO USUARIOS (CPF_USUARIO, EMPRESA_USUARIO, CADASTRO_USUARIO)
                VALUES(:CPF_USUARIO, :EMPRESA_USUARIO, CURRENT_TIMESTAMP)";
        
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':CPF_USUARIO', $cpfUsuario, PDO::PARAM_STR);
        $stmt->bindParam(':EMPRESA_USUARIO', $data['EMPRESA_USUARIO']);
        $stmt->execute();
    }
}

header("location: /admin/usuarios/?status=201");

?>