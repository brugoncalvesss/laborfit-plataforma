<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

if (!$data['id']) {
    die('Erro: #ID da categoria não informado.');
}

if ($_FILES["arquivo"]["name"]) {
    $imagem = uploadFile($_FILES);
} else {
    $imagem = $data['imagem'];
}

$destaque = $data['destaque'] ?: 0;

$PDO = db_connect();
$sql = "UPDATE
            CATEGORIAS
        SET
            NOME_CATEGORIA = :NOME_CATEGORIA, IMG_CATEGORIA = :IMG_CATEGORIA, DESTAQUE_CATEGORIA = :DESTAQUE_CATEGORIA, DESC_CATEGORIA = :DESC_CATEGORIA
        WHERE
            ID_CATEGORIA = :ID_CATEGORIA;";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_CATEGORIA', $data['nome']);
$stmt->bindParam(':IMG_CATEGORIA', $imagem);
$stmt->bindParam(':DESTAQUE_CATEGORIA', $destaque);
$stmt->bindParam(':DESC_CATEGORIA', $data['descricao']);
$stmt->bindParam(':ID_CATEGORIA', $data['id'], PDO::PARAM_INT);

try{
    $stmt->execute();
    header("location: /admin/categorias/?status=200");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro ao editar álbum: " . $e->getMessage());
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
