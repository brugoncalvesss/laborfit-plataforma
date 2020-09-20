<?php

// MySQL
define('DB_HOST', '192.185.213.43');
define('DB_USER', 'wowlif90_prod');
define('DB_PASS', '^R[7LWG!8xI7');
define('DB_NAME', 'wowlif90_plataforma');

function limparCaracteres($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}

function db_connect()
{
    $PDO = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
  
    return $PDO;
}

function getBannerFrontPage()
{
    $PDO = db_connect();
    $sql = "SELECT * FROM
                BANNERS
            WHERE
                EMPRESA_BANNER = :EMPRESA_BANNER
            ORDER BY
                ID_BANNER
            DESC";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':EMPRESA_BANNER', $_SESSION['EMPRESA_USUARIO'], PDO::PARAM_INT);

    try{
        $stmt->execute();
        $arBanners = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar banners: " . $e->getMessage());
    }

    return $arBanners;
}

function getAlbumDestaque()
{
    $PDO = db_connect();

    $sql = "SELECT * FROM
                CATEGORIAS
            WHERE
                DESTAQUE_CATEGORIA = 1
                AND EMPRESA_CATEGORIA = :EMPRESA_CATEGORIA
            ORDER BY
                ID_CATEGORIA DESC
            LIMIT 3";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':EMPRESA_CATEGORIA', $_SESSION['EMPRESA_USUARIO'], PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }

	return $result;
}

function getAlbums()
{
    $PDO = db_connect();

    $sql = "SELECT * FROM
                CATEGORIAS
            WHERE
                DESTAQUE_CATEGORIA <> 1
                AND EMPRESA_CATEGORIA = :EMPRESA_CATEGORIA
            ORDER BY
                ID_CATEGORIA DESC
            LIMIT 3";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':EMPRESA_CATEGORIA', $_SESSION['EMPRESA_USUARIO'], PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }

	return $result;
}

function getAlbum(int $id)
{
    if (!$id) {
        return false;
    }

    $PDO = db_connect();
    $sql = "SELECT * FROM
                VIDEOS
            INNER JOIN CATEGORIAS ON
                CATEGORIAS.ID_CATEGORIA = VIDEOS.ALBUM_VIDEO
            WHERE
                VIDEOS.STATUS_VIDEO = 1
                AND VIDEOS.EMPRESA_VIDEO = :EMPRESA_VIDEO
                AND CATEGORIAS.ID_CATEGORIA = :ID_CATEGORIA
            ORDER BY
                VIDEOS.ID_VIDEO DESC";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':EMPRESA_VIDEO', $_SESSION['EMPRESA_USUARIO'], PDO::PARAM_INT);
    $stmt->bindParam(':ID_CATEGORIA', $id, PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeo: " . $e->getMessage());
    }

	return $result;
}

function getCategoria(int $id)
{
    if (!$id) {
        return false;
    }

    $PDO = db_connect();
    $sql = "SELECT * FROM
                CATEGORIAS
            WHERE
                CATEGORIAS.ID_CATEGORIA = :ID_CATEGORIA
            LIMIT 1";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_CATEGORIA', $id, PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeo: " . $e->getMessage());
    }

	return $result;
}

function getVideo(int $id) {

    if (!$id) {
        die("Erro ao carregar vídeo. #ID não informado.");
    }

    $PDO = db_connect();
    $sql = "SELECT * FROM
                VIDEOS
            INNER JOIN CATEGORIAS ON
                VIDEOS.ALBUM_VIDEO = CATEGORIAS.ID_CATEGORIA
            WHERE
                VIDEOS.STATUS_VIDEO = 1
                AND VIDEOS.LINK_VIDEO = :LINK_VIDEO
            LIMIT 1";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':LINK_VIDEO', $id, PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeo: " . $e->getMessage());
    }

	return $result;
}

function getVideosRelacionados(int $idVideo, int $idCategoria) {

    if (!$idVideo || !$idCategoria) {
        return false;
    }

    $PDO = db_connect();
    $sql = "SELECT * FROM
                VIDEOS
            WHERE
                VIDEOS.STATUS_VIDEO = 1
                AND VIDEOS.LINK_VIDEO <> :LINK_VIDEO
                AND VIDEOS.ALBUM_VIDEO = :ALBUM_VIDEO
            ORDER BY RAND() LIMIT 3";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':LINK_VIDEO', $idVideo, PDO::PARAM_INT);
    $stmt->bindParam(':ALBUM_VIDEO', $idCategoria, PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }

	return $result;
}

function getTemas()
{
    $PDO = db_connect();

    $sql = "SELECT * FROM
                TEMAS
            WHERE
                TEMAS.EMPRESA_TEMA = :EMPRESA_TEMA
            ORDER BY
                TEMAS.NOME_TEMA ASC";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':EMPRESA_TEMA', $_SESSION['EMPRESA_USUARIO'], PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }

	return $result;
}

function getTemaURL($idAlbum = null, $idTema = null) {
    $url = "/album.php?q=".$idAlbum."&idTema=".$idTema;
    return $url;
}