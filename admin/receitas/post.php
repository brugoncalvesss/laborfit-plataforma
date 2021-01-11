<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

$destaque = intval($data['DESTAQUE_RECEITA']);

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
$stmt->bindParam(':DESTAQUE_RECEITA', $destaque);
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

$PDO = db_connect();
$sql = "DELETE FROM DESTAQUES_VIDEOS WHERE ID_VIDEO = :ID_VIDEO LIMIT 1";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_VIDEO', $data['ID_RECEITA'], PDO::PARAM_INT);
$stmt->execute();

if ($destaque) {
    $PDO = db_connect();
    $sql = "INSERT INTO DESTAQUES_VIDEOS (ID_DESTAQUE, ID_VIDEO, DATA_EXIBICAO)
            VALUES (:ID_DESTAQUE, :ID_VIDEO, :DATA_EXIBICAO)";
    $stmt = $PDO->prepare($sql);

    $date = date("Y-m-d");
    $stmt->bindParam(':ID_DESTAQUE', $data['DESTAQUE_RECEITA'], PDO::PARAM_INT);
    $stmt->bindParam(':ID_VIDEO', $data['ID_RECEITA'], PDO::PARAM_INT);
    $stmt->bindParam(':DATA_EXIBICAO', $date);
    $stmt->execute();
}


if ($data['ID_PROGRAMA']) {
    $arrAula = getReceitaDoPrograma($data['ID_RECEITA']);
    $data['ID_ETAPA'] = $data['ID_ETAPA'] ?: 0;
}

if (!empty($arrAula)) {
    $sql = "UPDATE AULAS
            SET FK_ETAPA = :FK_ETAPA, FK_PROGRAMA = :FK_PROGRAMA
            WHERE REF_AULA = :REF_AULA AND FL_RECEITA_AULA = :FL_RECEITA_AULA";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':REF_AULA', $data['ID_RECEITA']);
    $stmt->bindValue(':FK_ETAPA', $data['ID_ETAPA']);
    $stmt->bindValue(':FK_PROGRAMA', $data['ID_PROGRAMA']);
    $stmt->bindValue(':FL_RECEITA_AULA', 1);
    $stmt->execute();
}

if ($data['ID_PROGRAMA'] && empty($arrAula)) {
    $sql = "INSERT INTO AULAS
            (REF_AULA, FK_ETAPA, FK_PROGRAMA, FL_RECEITA_AULA)
            VALUES
            (:REF_AULA, :FK_ETAPA, :FK_PROGRAMA, :FL_RECEITA_AULA)";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':REF_AULA', $data['ID_RECEITA']);
    $stmt->bindValue(':FK_ETAPA', $data['ID_ETAPA']);
    $stmt->bindValue(':FK_PROGRAMA', $data['ID_PROGRAMA']);
    $stmt->bindValue(':FL_RECEITA_AULA', 1);
    $stmt->execute();
}

if (empty($data['ID_PROGRAMA'])) {
    $sql = "DELETE FROM AULAS
            WHERE REF_AULA = :REF_AULA AND FL_RECEITA_AULA = 1 LIMIT 1";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':REF_AULA', $data['ID_RECEITA']);
    $stmt->execute();
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