<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$data = filter_input_array(INPUT_POST);

$data['DESTAQUE_VIDEO'] = isset($data['DESTAQUE_VIDEO']) ? $data['DESTAQUE_VIDEO'] : 0;

if ($data['LINK_VIDEO']) {
    $data['LINK_VIDEO'] = getVimeoId($data['LINK_VIDEO']);
}

if (!empty($_FILES['arquivo']['name'])) {
    $imagem = uploadFile($_FILES);
} else {
    $imagem = null;
}

$sql = "INSERT INTO
            VIDEOS (NOME_VIDEO, LINK_VIDEO, THUMB_VIDEO, DESC_VIDEO, DESTAQUE_VIDEO, INTRO_VIDEO, CADASTRO_VIDEO)
        VALUES
            (:NOME_VIDEO, :LINK_VIDEO, :THUMB_VIDEO, :DESC_VIDEO, :DESTAQUE_VIDEO, :INTRO_VIDEO, CURRENT_TIMESTAMP)";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':NOME_VIDEO', $data['NOME_VIDEO']);
$stmt->bindParam(':LINK_VIDEO', $data['LINK_VIDEO']);
$stmt->bindParam(':THUMB_VIDEO', $imagem);
$stmt->bindParam(':DESC_VIDEO', $data['DESC_VIDEO']);
$stmt->bindParam(':DESTAQUE_VIDEO', $data['DESTAQUE_VIDEO']);
$stmt->bindParam(':INTRO_VIDEO', $data['INTRO_VIDEO']);

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
            $sql = "INSERT INTO CATEGORIAS_VIDEOS (ID_CATEGORIA, ID_VIDEO)
                    VALUES (:ID_CATEGORIA, :ID_VIDEO)";

            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':ID_CATEGORIA', $idCategoria);
            $stmt->bindParam(':ID_VIDEO', $lastIdVideo);
            $stmt->execute();
        }
    }
}

if ($data['TEMAS'] && $lastIdVideo) {
    $temas = implode(',', array_column(json_decode($data['TEMAS']), 'value'));
    $arTemas = explode(',', $temas);
    
    foreach ($arTemas as $tema) {
        $idTema = getIdPorNomeTema($tema)['ID_TEMA'];
        if ($idTema) {
            $PDO = db_connect();
            $sql = "INSERT INTO TEMAS_VIDEOS (ID_TEMA, ID_VIDEO)
                    VALUES (:ID_TEMA, :ID_VIDEO)";

            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':ID_TEMA', $idTema);
            $stmt->bindParam(':ID_VIDEO', $lastIdVideo);
            $stmt->execute();
        }
    }
}

header("location: /admin/paginas/?status=201");
exit();

function getVimeoId(string $link) {

    $partVideo = explode('vimeo.com/', $link);
    $idVideo = $partVideo[1] ?: '000000001';

    return $idVideo;
}

function uploadFile($file) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
    
    $temp = explode(".", $file["arquivo"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);

    $target_file = $target_dir . basename($newfilename);

    $result = move_uploaded_file($file['arquivo']['tmp_name'], $target_file);

    if (!$result) {
        $newfilename = 'Error: file upload';
    }

    return $newfilename;
}
