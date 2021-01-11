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

$destaque = intval($data['DESTAQUE_VIDEO']);

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
$stmt->bindParam(':DESTAQUE_VIDEO', $destaque);
$stmt->bindParam(':INTRO_VIDEO', $data['INTRO_VIDEO']);
$stmt->bindParam(':ID_VIDEO', $data['id'], PDO::PARAM_INT);
$stmt->execute();

if ($data['CATEGORIAS']) {
    deleteCategoriaPorIdVideo($data['id']);
    
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
            $stmt->bindParam(':ID_VIDEO', $data['id']);
            $stmt->execute();
        }
    }
}

if ($data['TEMAS']) {
    deleteTemaPorIdVideo($data['id']);

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
            $stmt->bindParam(':ID_VIDEO', $data['id']);
            $stmt->execute();
        }
    }
}

$PDO = db_connect();
$sql = "DELETE FROM DESTAQUES_VIDEOS WHERE ID_VIDEO = :ID_VIDEO LIMIT 1";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_VIDEO', $data['id'], PDO::PARAM_INT);
$stmt->execute();

if ($destaque) {
    $PDO = db_connect();
    $sql = "INSERT INTO DESTAQUES_VIDEOS (ID_DESTAQUE, ID_VIDEO, DATA_EXIBICAO)
            VALUES (:ID_DESTAQUE, :ID_VIDEO, :DATA_EXIBICAO)";
    $stmt = $PDO->prepare($sql);

    $date = date("Y-m-d");
    $stmt->bindParam(':ID_DESTAQUE', $data['DESTAQUE_VIDEO'], PDO::PARAM_INT);
    $stmt->bindParam(':ID_VIDEO', $data['id'], PDO::PARAM_INT);
    $stmt->bindParam(':DATA_EXIBICAO', $date);
    $stmt->execute();
}

if ($data['ID_PROGRAMA']) {
    $arrAula = getAulaDoPrograma($data['id']);
    $data['ID_ETAPA'] = $data['ID_ETAPA'] ?: 0;
}

if (!empty($arrAula)) {
    $sql = "UPDATE AULAS
            SET FK_ETAPA = :FK_ETAPA, FK_PROGRAMA = :FK_PROGRAMA
            WHERE REF_AULA = :REF_AULA";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':REF_AULA', $data['id']);
    $stmt->bindValue(':FK_ETAPA', $data['ID_ETAPA']);
    $stmt->bindValue(':FK_PROGRAMA', $data['ID_PROGRAMA']);
    $stmt->execute();
}

if ($data['ID_PROGRAMA'] && empty($arrAula)) {
    $sql = "INSERT INTO AULAS
            (REF_AULA, FK_ETAPA, FK_PROGRAMA)
            VALUES
            (:REF_AULA, :FK_ETAPA, :FK_PROGRAMA)";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':REF_AULA', $data['id']);
    $stmt->bindValue(':FK_ETAPA', $data['ID_ETAPA']);
    $stmt->bindValue(':FK_PROGRAMA', $data['ID_PROGRAMA']);
    $stmt->execute();
}

if (empty($data['ID_PROGRAMA'])) {
    $sql = "DELETE FROM AULAS
            WHERE REF_AULA = :REF_AULA AND FL_RECEITA_AULA = 0 LIMIT 1";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':REF_AULA', $data['id']);
    $stmt->execute();
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