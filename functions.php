<?php

// MySQL
define('DB_HOST', '192.185.213.43');
define('DB_USER', 'wowlif90_prod');
define('DB_PASS', '^R[7LWG!8xI7');
define('DB_NAME', 'wowlif90_plataforma');

function db_connect()
{
    $PDO = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
  
    return $PDO;
}

function getPageCompany(int $id, int $idCategoria = null) {

    if (!$id) {
        die("Erro ao carregar página. #ID não informado.");
    }

    $statusVideo = 1;
    $PDO = db_connect();

    if ($idCategoria) {
        $sql = "SELECT *
                FROM
                    VIDEOS
                INNER JOIN EMPRESAS ON
                    VIDEOS.EMPRESA_VIDEO = EMPRESAS.ID_EMPRESA
                WHERE
                    EMPRESA_VIDEO = :EMPRESA_VIDEO
                    AND STATUS_VIDEO = :STATUS_VIDEO
                    AND CATEGORIA_VIDEO = :CATEGORIA_VIDEO
                ORDER BY ID_VIDEO DESC";

        $stmt = $PDO->prepare($sql);

        $stmt->bindParam(':STATUS_VIDEO', $statusVideo, PDO::PARAM_INT);
        $stmt->bindParam(':EMPRESA_VIDEO', $id, PDO::PARAM_INT);
        $stmt->bindParam(':CATEGORIA_VIDEO', $idCategoria, PDO::PARAM_INT);
    } else {
        $sql = "SELECT *
                FROM
                    VIDEOS
                INNER JOIN EMPRESAS ON
                    VIDEOS.EMPRESA_VIDEO = EMPRESAS.ID_EMPRESA
                WHERE
                    EMPRESA_VIDEO = :EMPRESA_VIDEO
                    AND STATUS_VIDEO = :STATUS_VIDEO
                ORDER BY ID_VIDEO DESC";

        $stmt = $PDO->prepare($sql);

        $stmt->bindParam(':STATUS_VIDEO', $statusVideo, PDO::PARAM_INT);
        $stmt->bindParam(':EMPRESA_VIDEO', $id, PDO::PARAM_INT);
    }

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }

	return $result;

}

function getBannerCompany(int $idEmpresa)
{
    $PDO = db_connect();
    $sql = "SELECT * FROM BANNERS WHERE EMPRESA_BANNER = :EMPRESA_BANNER ORDER BY ID_BANNER DESC";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':EMPRESA_BANNER', $idEmpresa, PDO::PARAM_INT);

    try{
        $stmt->execute();
        $arBanners = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar banners: " . $e->getMessage());
    }

    return $arBanners;
}

function getVideoId(int $id) {

    if (!$id) {
        die("Erro ao carregar vídeo. #ID não informado.");
    }

    $PDO = db_connect();
    $sql = "SELECT * FROM
                VIDEOS
            INNER JOIN CATEGORIAS ON
                VIDEOS.EMPRESA_VIDEO = CATEGORIAS.ID_CATEGORIA
            WHERE LINK_VIDEO = :LINK_VIDEO
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

function getSelectCategoriasVideo(int $id = null) {

    $PDO = db_connect();
    $sql = "SELECT * FROM CATEGORIAS";
    $stmt = $PDO->prepare($sql);
    
    try{
        $stmt->execute();
        $arCategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar categorias: " . $e->getMessage());
    }

	if (!empty($arCategorias)) {
		foreach ($arCategorias as $categoria) {
			$selected = false;
			if ($id && ($categoria['ID_CATEGORIA'] == $id)) {
				$selected = 'selected';
			}
			$option = "<option {$selected} value='{$categoria['ID_CATEGORIA']}'>{$categoria['NOME_CATEGORIA']}</option>";
			echo $option;
		}
	}
}

function limparCaracteres($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}

function getPageDestaques(int $id) {

    if (!$id) {
        die("Erro ao carregar página. #ID não informado.");
    }

    $status = 1;
    $PDO = db_connect();

    $sql = "SELECT *
            FROM
                VIDEOS
            INNER JOIN EMPRESAS ON
                VIDEOS.EMPRESA_VIDEO = EMPRESAS.ID_EMPRESA
            INNER JOIN CATEGORIAS ON
                CATEGORIAS.ID_CATEGORIA = VIDEOS.CATEGORIA_VIDEO
            WHERE
                EMPRESA_VIDEO = :EMPRESA_VIDEO
                AND STATUS_VIDEO = :STATUS_VIDEO
                AND DESTAQUE_CATEGORIA = :DESTAQUE_CATEGORIA
            GROUP BY
                CATEGORIAS.ID_CATEGORIA
            ORDER BY
                ID_VIDEO DESC
            LIMIT 3";
    $stmt = $PDO->prepare($sql);

    $stmt->bindParam(':STATUS_VIDEO', $status, PDO::PARAM_INT);
    $stmt->bindParam(':DESTAQUE_CATEGORIA', $status, PDO::PARAM_INT);
    $stmt->bindParam(':EMPRESA_VIDEO', $id, PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }

	return $result;
}

function getPageAlbums(int $id) {

    if (!$id) {
        die("Erro ao carregar página. #ID não informado.");
    }

    $status = 1;
    $album = 0;
    $PDO = db_connect();

    $sql = "SELECT *
            FROM
                VIDEOS
            INNER JOIN EMPRESAS ON
                VIDEOS.EMPRESA_VIDEO = EMPRESAS.ID_EMPRESA
            INNER JOIN CATEGORIAS ON
	            CATEGORIAS.ID_CATEGORIA = VIDEOS.CATEGORIA_VIDEO
            WHERE
                EMPRESA_VIDEO = :EMPRESA_VIDEO
                AND STATUS_VIDEO = :STATUS_VIDEO
                AND DESTAQUE_CATEGORIA = :DESTAQUE_CATEGORIA
            GROUP BY
                CATEGORIAS.NOME_CATEGORIA
            ORDER BY
                ID_VIDEO DESC";

    $stmt = $PDO->prepare($sql);

    $stmt->bindParam(':STATUS_VIDEO', $status, PDO::PARAM_INT);
    $stmt->bindParam(':DESTAQUE_CATEGORIA', $album, PDO::PARAM_INT);
    $stmt->bindParam(':EMPRESA_VIDEO', $id, PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }

	return $result;
}

function getVideosAlbums(int $idAlbum) {

    if (!$idAlbum) {
        die("Erro ao carregar página. #ID não informado.");
    }

    $status = 1;

    $PDO = db_connect();
    $sql = "SELECT *
            FROM
                VIDEOS
            INNER JOIN CATEGORIAS ON
	            CATEGORIAS.ID_CATEGORIA = VIDEOS.CATEGORIA_VIDEO
            WHERE
                STATUS_VIDEO = :STATUS_VIDEO
                AND ID_CATEGORIA = :ID_CATEGORIA
                AND EMPRESA_VIDEO = :EMPRESA_VIDEO
            ORDER BY
                ID_VIDEO DESC";

    $stmt = $PDO->prepare($sql);

    $stmt->bindParam(':STATUS_VIDEO', $status, PDO::PARAM_INT);
    $stmt->bindParam(':ID_CATEGORIA', $idAlbum, PDO::PARAM_INT);
    $stmt->bindParam(':EMPRESA_VIDEO', $_SESSION['empresa'], PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }

	return $result;
}

function getVideosRelacionados(int $idCategoria) {

    if (!$idCategoria) {
        return false;
    }

    $status = 1;

    $PDO = db_connect();
    $sql = "SELECT *
            FROM
                VIDEOS
            INNER JOIN CATEGORIAS ON
	            CATEGORIAS.ID_CATEGORIA = VIDEOS.CATEGORIA_VIDEO
            WHERE
                STATUS_VIDEO = :STATUS_VIDEO
                AND ID_CATEGORIA = :ID_CATEGORIA
            ORDER BY RAND() LIMIT 3";

    $stmt = $PDO->prepare($sql);

    $stmt->bindParam(':STATUS_VIDEO', $status, PDO::PARAM_INT);
    $stmt->bindParam(':ID_CATEGORIA', $idCategoria, PDO::PARAM_INT);

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }

	return $result;
}