<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

if (empty($_POST)) {
    die("Erro: Nenhuma informação enviada.");
}

$idEmpresa = $_POST['empresa'] ?: null;

if (empty($idEmpresa)) {
    die("Erro: Empresa não informada.");
}

$imagem = null;

if ($_FILES) {
    $imagem = uploadFile($_FILES);
}

$sql = "INSERT INTO
            BANNERS (IMG_BANNER, EMPRESA_BANNER)
        VALUES
            (:IMG_BANNER, :EMPRESA_BANNER)";

$PDO = db_connect();
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':IMG_BANNER', $imagem);
$stmt->bindParam(':EMPRESA_BANNER', $idEmpresa);

try {
    $stmt->execute();
    header("location: /admin/banners/banners.php?id=${idEmpresa}&status=201");
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
        die("Erro ao enviar arquivo.");
    }

    return $newfilename;
}

