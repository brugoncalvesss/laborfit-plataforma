<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: Nenhuma informação enviada.');
}

if (empty($data['empresa'])) {
    die("Erro: Empresa não informada.");
}

if ($_FILES) {
    $imagem = uploadFile($_FILES);
} else {
    $imagem = null;
}

$sql = "INSERT INTO
            BANNERS (IMG_BANNER, EMPRESA_BANNER, LINK_BANNER)
        VALUES
            (:IMG_BANNER, :EMPRESA_BANNER, :LINK_BANNER)";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':IMG_BANNER', $imagem);
$stmt->bindParam(':EMPRESA_BANNER', $data['empresa']);
$stmt->bindParam(':LINK_BANNER', $data['link']);

try {
    $stmt->execute();
    $idEmpresa = $data['empresa'];
    header("location: /admin/banners/lista.php?id=${idEmpresa}&status=201");
    exit();
} catch(PDOException $e) {
    throw new Exception("Erro salvar página: " . $e->getMessage());
}

function uploadFile($file) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
    
    $temp = explode(".", $file["arquivo"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);

    $target_file = $target_dir . basename($newfilename);

    $result = move_uploaded_file($file['arquivo']['tmp_name'], $target_file);

    if (!$result) {
        $newfilename = 'Erro: upload file.';
    }

    return $newfilename;
}

