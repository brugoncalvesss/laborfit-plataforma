<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$nomeCategoria = $_POST['nome'] ?: null;
$destaque = (int)$_POST['destaque'] ?: 0;
$descricao = $_POST['descricao'] ?: null;
$imagem = null;

if (empty($nomeCategoria)) {
    die('Erro: Informe o nome do álbum.');
}

if ($_FILES["arquivo"]["name"]) {
    $imagem = uploadFile($_FILES);
}

$PDO = db_connect();
$sql = "INSERT INTO
            CATEGORIAS (NOME_CATEGORIA, IMG_CATEGORIA, DESTAQUE_CATEGORIA, DESC_CATEGORIA, EMPRESA_CATEGORIA)
        VALUES
            (:NOME_CATEGORIA, :IMG_CATEGORIA, :DESTAQUE_CATEGORIA, :DESC_CATEGORIA, :EMPRESA_CATEGORIA)";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_CATEGORIA', $nomeCategoria);
$stmt->bindParam(':IMG_CATEGORIA', $imagem);
$stmt->bindParam(':DESTAQUE_CATEGORIA', $destaque);
$stmt->bindParam(':DESC_CATEGORIA', $descricao);
$stmt->bindParam(':EMPRESA_CATEGORIA', $_SESSION['ID_EMPRESA']);

try{
    $stmt->execute();
    header("location: /admin/categorias/?status=200");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro ao cadastrar álbum: " . $e->getMessage());
}

function uploadFile($file) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
     
    $temp = explode(".", $file["arquivo"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);

    $target_file = $target_dir . basename($newfilename);

    $result = move_uploaded_file($file['arquivo']['tmp_name'], $target_file);

    if (!$result) {
        $newfilename = 'error: upload file';
    }

    return $newfilename;
}
