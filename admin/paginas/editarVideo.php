<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

if (!$data['id']) {
    die('Erro: #ID do vídeo não informado.');
}

if ($data['link']) {
    $data['link'] = getVimeoId($data['link']);
}

if ($_FILES["arquivo"]["name"]) {
    $imagem = uploadFile($_FILES);
} else {
    $imagem = $data['imagem'];
}

$PDO = db_connect();
$sql = "UPDATE
            VIDEOS
        SET
            NOME_VIDEO = :NOME_VIDEO, LINK_VIDEO = :LINK_VIDEO, THUMB_VIDEO = :THUMB_VIDEO, DESC_VIDEO = :DESC_VIDEO, DESTAQUE_VIDEO = :DESTAQUE_VIDEO, INTRO_VIDEO = :INTRO_VIDEO
        WHERE
            ID_VIDEO = :ID_VIDEO";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_VIDEO', $data['nome']);
$stmt->bindParam(':LINK_VIDEO', $data['link']);
$stmt->bindParam(':THUMB_VIDEO', $imagem);
$stmt->bindParam(':DESC_VIDEO', $data['descricao']);
$stmt->bindParam(':DESTAQUE_VIDEO', $data['DESTAQUE_VIDEO']);
$stmt->bindParam(':INTRO_VIDEO', $data['INTRO_VIDEO']);
$stmt->bindParam(':ID_VIDEO', $data['id'], PDO::PARAM_INT);
$stmt->execute();

if ($data['CATEGORIAS']) {
    $categorias = implode(',', array_column(json_decode($data['CATEGORIAS']), 'value'));
    $arCategorias = explode(',', $categorias);
    
    foreach ($arCategorias as $categoria) {
        $idCategoria = getIdPorNomeCategoria($categoria)['ID_CATEGORIA'];
        if ($idCategoria) {
            deleteCategoriaPorIdVideo($data['id']);

            $PDO = db_connect();
            $sql = "INSERT INTO CATEGORIAS_VIDEOS (ID_CATEGORIA, ID_VIDEO)
                    VALUES (:ID_CATEGORIA, :ID_VIDEO)";

            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':ID_CATEGORIA', $idCategoria);
            $stmt->bindParam(':ID_VIDEO', $data['id']);
            $stmt->execute();
        }
    }
}

if ($data['TEMAS']) {
    $temas = implode(',', array_column(json_decode($data['TEMAS']), 'value'));
    $arTemas = explode(',', $temas);
    
    foreach ($arTemas as $tema) {
        $idTema = getIdPorNomeTema($tema)['ID_TEMA'];
        if ($idTema) {
            deleteTemaPorIdVideo($data['id']);

            $PDO = db_connect();
            $sql = "INSERT INTO TEMAS_VIDEOS (ID_TEMA, ID_VIDEO)
                    VALUES (:ID_TEMA, :ID_VIDEO)";

            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':ID_TEMA', $idTema);
            $stmt->bindParam(':ID_VIDEO', $data['id']);
            $stmt->execute();
        }
    }
}

header("Location: /admin/paginas/?status=201");
exit();

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

function getVimeoId(string $link) {

    $partVideo = explode('vimeo.com/', $link);
    $idVideo = $partVideo[1] ?: '000000001';

    return $idVideo;
}