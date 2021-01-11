<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$data = filter_input_array(INPUT_POST);

$destaque = intval($data['DESTAQUE_VIDEO']);

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
$stmt->bindParam(':DESTAQUE_VIDEO', $destaque);
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

if ($data['DESTAQUE_VIDEO'] && $lastIdVideo) {
    $sql = "INSERT INTO
                DESTAQUES_VIDEOS (ID_DESTAQUE, ID_VIDEO, DATA_EXIBICAO)
            VALUES
                (:ID_DESTAQUE, :ID_VIDEO, :DATA_EXIBICAO)";
    $PDO = db_connect();
    $stmt = $PDO->prepare($sql);

    $date = date("Y-m-d");
    $stmt->bindParam(':ID_DESTAQUE', $data['DESTAQUE_VIDEO'], PDO::PARAM_INT);
    $stmt->bindParam(':ID_VIDEO', $lastIdVideo, PDO::PARAM_INT);
    $stmt->bindParam(':DATA_EXIBICAO', $date);
    $stmt->execute();
}

if ($data['ID_PROGRAMA'] && $lastIdVideo) {

    $data['ID_ETAPA'] = $data['ID_ETAPA'] ?: 0;

    $sql = "INSERT INTO AULAS
                (REF_AULA, FK_ETAPA, FK_PROGRAMA)
            VALUES
                (:REF_AULA, :FK_ETAPA, :FK_PROGRAMA)";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':REF_AULA', $lastIdVideo);
    $stmt->bindValue(':FK_ETAPA', $data['ID_ETAPA']);
    $stmt->bindValue(':FK_PROGRAMA', $data['ID_PROGRAMA']);
    $stmt->execute();
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
