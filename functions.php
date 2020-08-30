<?php

// MySQL
define('DB_HOST', 'db4free.net');
define('DB_USER', 'devlocalhost');
define('DB_PASS', 'TSFW8gDqw3#JmLY');
define('DB_NAME', 'devplataforma');

ini_set('display_errors', true);
error_reporting(E_ALL);

function db_connect()
{
    $PDO = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
  
    return $PDO;
}

function getPageCompany(int $id) {

    if (!$id) {
        die("Erro ao carregar página. #ID não informado.");
    }

    $statusVideo = 1;
    
    $PDO = db_connect();
    $sql = "SELECT *
            FROM VIDEOS
            INNER JOIN EMPRESAS
            ON VIDEOS.EMPRESA_VIDEO = EMPRESAS.ID_EMPRESA
            WHERE EMPRESA_VIDEO = :EMPRESA_VIDEO AND STATUS_VIDEO = :STATUS_VIDEO";
    $stmt = $PDO->prepare($sql);

    $stmt->bindParam(':STATUS_VIDEO', $statusVideo, PDO::PARAM_INT);
    $stmt->bindParam(':EMPRESA_VIDEO', $id, PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }

	return $result;

}

function getVideoId(int $id) {

    if (!$id) {
        die("Erro ao carregar vídeo. #ID não informado.");
    }

    $PDO = db_connect();
    $sql = "SELECT * FROM VIDEOS WHERE ID_VIDEO = :ID_VIDEO LIMIT 1";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_VIDEO', $id, PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeo: " . $e->getMessage());
    }

	return $result;
}

function limparCaracteres($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}