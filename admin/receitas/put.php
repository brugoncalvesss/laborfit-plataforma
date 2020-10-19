<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

if ($_FILES["arquivo"]["name"]) {
    $imagem = uploadFile($_FILES);
}

$sql = "INSERT INTO RECEITAS (NOME_RECEITA, DESCRICAO_RECEITA, IMG_RECEITA, DESTAQUE_RECEITA)
        VALUES (:NOME_RECEITA, :DESCRICAO_RECEITA, :IMG_RECEITA, :DESTAQUE_RECEITA)";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_RECEITA', $data['NOME_RECEITA']);
$stmt->bindParam(':DESCRICAO_RECEITA', $data['DESCRICAO_RECEITA']);
$stmt->bindParam(':DESTAQUE_RECEITA', $data['DESTAQUE_RECEITA']);
$stmt->bindParam(':IMG_RECEITA', $imagem);

if ($stmt->execute()) {
    $lastIdVideo = $PDO->lastInsertId();
}

if ($data['CATEGORIAS'] && $lastIdVideo) {
    $categorias = implode(',', array_column(json_decode($data['CATEGORIAS']), 'value'));
    $arCategorias = explode(',', $categorias);
    
    foreach ($arCategorias as $categoria) {
        $idCategoria = getIdPorNomeCategoria($categoria)['ID_CATEGORIA'];
        if ($idCategoria) {
            $PDO = db_connect();
            $sql = "INSERT INTO CATEGORIAS_RECEITAS (ID_CATEGORIA, ID_RECEITA)
                    VALUES (:ID_CATEGORIA, :ID_RECEITA)";

            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':ID_CATEGORIA', $idCategoria);
            $stmt->bindParam(':ID_RECEITA', $lastIdVideo);
            $stmt->execute();
        }
    }
}

header("location: /admin/receitas/?status=201");
exit;

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
