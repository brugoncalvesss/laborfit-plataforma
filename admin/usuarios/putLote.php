<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'; ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

    <header class="my-3">
        <a href="/admin/usuarios/" class="btn btn-link">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </header>
    
    
    <?php
    if (!$_FILES["arquivo"]["name"]) {
        die("Arquivo não enviado.");
    }

    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/arquivos/';
        
    $temp = explode(".", $_FILES["arquivo"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);

    $target_file = $target_dir . basename($newfilename);

    $result = move_uploaded_file($_FILES['arquivo']['tmp_name'], $target_file);

    if (!$result) {
        die('Erro ao carregar arquivo.');
    }

    $file = fopen($target_file, 'r');
    $i = 0;
    $newUser = [];
    while (($line = fgetcsv($file)) !== FALSE) {
        if ($i) {
            $newUser[$i]['NOME_USUARIO'] = $line[0];
            $newUser[$i]['CPF_USUARIO'] = $line[1];
            $newUser[$i]['EMAIL_USUARIO'] = $line[2];
            $newUser[$i]['EMPRESA_USUARIO'] = $line[3];
            $newUser[$i]['DEPARTAMENTO_USUARIO'] = $line[4];
            $newUser[$i]['CARGO_USUARIO'] = $line[5];
        }
        $i++;
    }
    fclose($file);

    $result = [];
    $PDO = db_connect();

    foreach ($newUser as $key => $usuario) {

        $usuario['CPF_USUARIO'] = limparCaracteres($usuario['CPF_USUARIO']);

        if (verificaCpfUsuarioExistente($usuario['CPF_USUARIO'])) {
            $result[] = "Usuário com o CPF {$usuario['CPF_USUARIO']} já está cadastrado.";
            continue;
        }
        
        $usuario['EMPRESA_USUARIO'] = verificaIdEmpresa($usuario['EMPRESA_USUARIO']);

        $sql = "INSERT INTO
                    USUARIOS (NOME_USUARIO, CPF_USUARIO, EMAIL_USUARIO, EMPRESA_USUARIO, DEPARTAMENTO_USUARIO, CARGO_USUARIO, CADASTRO_USUARIO)
                VALUES
                    (:NOME_USUARIO, :CPF_USUARIO, :EMAIL_USUARIO, :EMPRESA_USUARIO, :DEPARTAMENTO_USUARIO, :CARGO_USUARIO, CURRENT_TIMESTAMP)";

        $stmt = $PDO->prepare($sql);
        $stmt->bindValue(':NOME_USUARIO', $usuario['NOME_USUARIO']);
        $stmt->bindValue(':CPF_USUARIO', $usuario['CPF_USUARIO']);
        $stmt->bindValue(':EMAIL_USUARIO', $usuario['EMAIL_USUARIO']);
        $stmt->bindValue(':EMPRESA_USUARIO', $usuario['EMPRESA_USUARIO']['ID_EMPRESA']);
        $stmt->bindValue(':DEPARTAMENTO_USUARIO', $usuario['DEPARTAMENTO_USUARIO']);
        $stmt->bindValue(':CARGO_USUARIO', $usuario['CARGO_USUARIO']);

        if ($stmt->execute()) {
            $result[] = "Usuário com o CPF {$usuario['CPF_USUARIO']} cadastrado no sistema.";
        }
    }
    ?>

    <div class="my-3">
    <?php
    if (count($result)) {
        foreach ($result as $res) {
            echo $res . "<br>";
        }
    }
    ?>
    </div>

</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'; ?>