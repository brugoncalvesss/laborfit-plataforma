<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

if ($_FILES["arquivo"]["name"]) {
    $imagem = uploadFile($_FILES);
} else {
    $imagem = $data['IMG_RECEITA'];
}

$sql = "UPDATE RECEITAS
        SET NOME_RECEITA = :NOME_RECEITA, DESCRICAO_RECEITA = :DESCRICAO_RECEITA, IMG_RECEITA = :IMG_RECEITA, DESTAQUE_RECEITA = :DESTAQUE_RECEITA
        WHERE ID_RECEITA = :ID_RECEITA";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_RECEITA', $data['NOME_RECEITA']);
$stmt->bindParam(':DESCRICAO_RECEITA', $data['DESCRICAO_RECEITA']);
$stmt->bindParam(':ID_RECEITA', $data['ID_RECEITA']);
$stmt->bindParam(':IMG_RECEITA', $imagem);
$stmt->bindParam(':DESTAQUE_RECEITA', $data['DESTAQUE_RECEITA']);
$stmt->execute();

if ($data['CATEGORIAS']) {
    deleteCategoriaPorIdReceita($data['ID_RECEITA']);
    
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
            $stmt->bindParam(':ID_RECEITA', $data['ID_RECEITA']);
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