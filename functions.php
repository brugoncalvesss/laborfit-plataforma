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
    $sql = "SELECT * FROM BANNERS
            ORDER BY
                ID_BANNER
            DESC";
    $stmt = $PDO->prepare($sql);

    try{
        $stmt->execute();
        $arBanners = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar banners: " . $e->getMessage());
    }

    return $arBanners;
}

function getVideosDestaque($id)
{
    $PDO = db_connect();

    $sql = "SELECT * FROM
                DESTAQUES_VIDEOS
            INNER JOIN VIDEOS ON
                VIDEOS.ID_VIDEO = DESTAQUES_VIDEOS.ID_VIDEO
            WHERE
                DESTAQUES_VIDEOS.DATA_EXIBICAO >= CURRENT_DATE()
                AND DESTAQUES_VIDEOS.ID_DESTAQUE = :ID_DESTAQUE
            LIMIT 1";
    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':ID_DESTAQUE', $id);

    try{
        $stmt->execute();
        $result = current($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }

	return $result;
}

function getReceitaDestaque()
{
    verificaSeExisteReceitaDestaque();

    $sql = "SELECT * FROM RECEITAS
            WHERE
                RECEITAS.EXIBICAO_RECEITA = CURRENT_DATE()
                AND RECEITAS.DESTAQUE_RECEITA = 1
            LIMIT 1";

    $PDO = db_connect();
    $stmt = $PDO->prepare($sql);

    try{
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar receitas: " . $e->getMessage());
    }
}

function getAlbums()
{
    $PDO = db_connect();

    $sql = "SELECT * FROM
                CATEGORIAS
            ORDER BY
                ID_CATEGORIA DESC";
    $stmt = $PDO->prepare($sql);

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
                AND CATEGORIAS.ID_CATEGORIA = :ID_CATEGORIA
            ORDER BY
                VIDEOS.ID_VIDEO DESC";

    $stmt = $PDO->prepare($sql);
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
            WHERE
                VIDEOS.STATUS_VIDEO = 1
                AND VIDEOS.LINK_VIDEO = :LINK_VIDEO
            LIMIT 1";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':LINK_VIDEO', $id, PDO::PARAM_INT);

    try{
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeo: " . $e->getMessage());
    }
}

function getVideosRelacionados(int $idVideo) {

    if (!$idVideo) {
        return false;
    }

    $PDO = db_connect();

    $sql = "SELECT ID_CATEGORIA FROM CATEGORIAS_VIDEOS WHERE ID_VIDEO = :ID_VIDEO LIMIT 1";
    $stmt =$PDO->prepare($sql);
    $stmt->bindParam(':ID_VIDEO', $idVideo, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result[0]['ID_CATEGORIA'])) {
        return false;
    }

    $sql = "SELECT * FROM
                CATEGORIAS_VIDEOS
            INNER JOIN VIDEOS ON
                VIDEOS.ID_VIDEO = CATEGORIAS_VIDEOS.ID_VIDEO
            WHERE
                CATEGORIAS_VIDEOS.ID_CATEGORIA = :ID_CATEGORIA
                AND CATEGORIAS_VIDEOS.ID_VIDEO <> :ID_VIDEO
            ORDER BY RAND() LIMIT 3";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_CATEGORIA', $result[0]['ID_CATEGORIA'], PDO::PARAM_INT);
    $stmt->bindParam(':ID_VIDEO', $idVideo, PDO::PARAM_INT);

    try{
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeos: " . $e->getMessage());
    }
}

function getTemas()
{
    $PDO = db_connect();

    $sql = "SELECT TEMAS.ID_TEMA, TEMAS.NOME_TEMA FROM TEMAS
            INNER JOIN TEMAS_VIDEOS ON
                TEMAS_VIDEOS.ID_TEMA = TEMAS.ID_TEMA
            GROUP BY TEMAS.NOME_TEMA
            ORDER BY TEMAS.NOME_TEMA ASC";
    $stmt = $PDO->prepare($sql);

    try{
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar temas: " . $e->getMessage());
    }

	return 0;
}

function getAlbumFiltro(int $id, string $filtro)
{
    if (!$id || !$filtro) {
        return false;
    }

    $PDO = db_connect();
    $sql = "SELECT * FROM
                VIDEOS
            INNER JOIN CATEGORIAS ON
                CATEGORIAS.ID_CATEGORIA = VIDEOS.ALBUM_VIDEO
            WHERE
                VIDEOS.STATUS_VIDEO = 1
                AND CATEGORIAS.ID_CATEGORIA = :ID_CATEGORIA
                AND VIDEOS.TEMA_VIDEO LIKE :TEMA_VIDEO
            ORDER BY
                VIDEOS.ID_VIDEO DESC";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_CATEGORIA', $id, PDO::PARAM_INT);
    $stmt->bindValue(':TEMA_VIDEO', '%'.$filtro.'%');

    try{
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeo: " . $e->getMessage());
    }

	return $result;
}

function verificaSeExisteDestaque($idDestaque)
{
    $PDO = db_connect();

    $sql = "SELECT
                DATA_EXIBICAO
            FROM
                DESTAQUES_VIDEOS
            WHERE
                ID_DESTAQUE = :ID_DESTAQUE
            AND DATA_EXIBICAO >= CURDATE()";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_DESTAQUE', $idDestaque);
    $stmt->execute();
    $arDestaques = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($arDestaques)) {

        $sql = "SELECT * FROM
                    DESTAQUES_VIDEOS
                WHERE
                    ID_DESTAQUE = :ID_DESTAQUE";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':ID_DESTAQUE', $idDestaque, PDO::PARAM_INT);
        $stmt->execute();
        $arDestaques = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($arDestaques)) {

            $date = date("Y-m-d");

            foreach ($arDestaques as $destaque) {
                $sql = "UPDATE DESTAQUES_VIDEOS
                        SET DATA_EXIBICAO = :DATA_EXIBICAO
                        WHERE ID_DESTAQUE_VIDEO = :ID_DESTAQUE_VIDEO";
                $stmt = $PDO->prepare($sql);
                $stmt->bindParam(':ID_DESTAQUE_VIDEO', $destaque['ID_DESTAQUE_VIDEO']);
                $stmt->bindParam(':DATA_EXIBICAO', $date);
                $stmt->execute();
                $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
            }
        }

    }

}

function verificaSeExisteReceitaDestaque()
{
    $PDO = db_connect();

    $sql = "SELECT EXIBICAO_RECEITA
            FROM RECEITAS
            WHERE EXIBICAO_RECEITA >= CURDATE()";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $arDestaques = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($arDestaques)) {

        $sql = "SELECT * FROM RECEITAS
                WHERE DESTAQUE_RECEITA = 1";
        $stmt = $PDO->prepare($sql);
        $stmt->execute();
        $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $date = date("Y-m-d");

        foreach ($receitas as $destaque) {
            $sql = "UPDATE RECEITAS
                    SET EXIBICAO_RECEITA = :EXIBICAO_RECEITA
                    WHERE ID_RECEITA = :ID_RECEITA";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':ID_RECEITA', $destaque['ID_RECEITA']);
            $stmt->bindParam(':EXIBICAO_RECEITA', $date);
            $stmt->execute();
            $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
        }

    }
}

function getVideoDestaqueCategoria(int $idCategoria)
{
    if (!$idCategoria) {
        return false;
    }

    $PDO = db_connect();
    $sql = "SELECT * FROM VIDEOS
            INNER JOIN CATEGORIAS_VIDEOS ON
                CATEGORIAS_VIDEOS.ID_VIDEO = VIDEOS.ID_VIDEO
            WHERE
                VIDEOS.STATUS_VIDEO = 1
                AND CATEGORIAS_VIDEOS.ID_CATEGORIA = :ID_CATEGORIA
            ORDER BY
                VIDEOS.ID_VIDEO
            DESC";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_CATEGORIA', $idCategoria, PDO::PARAM_INT);

    try{
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeo: " . $e->getMessage());
    }
}

function getTema(int $id) {

    if (!$id) {
        return 0;
    }

    $PDO = db_connect();

    $sql = "SELECT * FROM TEMAS
            WHERE TEMAS.ID_TEMA = :ID_TEMA
            LIMIT 1";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':ID_TEMA', $id, PDO::PARAM_INT);

    try{
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar temas: " . $e->getMessage());
    }
}

function getVideoPorIdTema(int $id)
{
    if (!$id) return false;

    $PDO = db_connect();
    $sql = "SELECT * FROM VIDEOS
            INNER JOIN TEMAS_VIDEOS ON
                TEMAS_VIDEOS.ID_VIDEO = VIDEOS.ID_VIDEO
            WHERE
                TEMAS_VIDEOS.ID_TEMA = :ID_TEMA
                AND VIDEOS.STATUS_VIDEO = 1";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_TEMA', $id);

    try{
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeo: " . $e->getMessage());
    }
}

function getVideoPorIdCategoria(int $id)
{
    if (!$id) return false;

    $PDO = db_connect();
    $sql = "SELECT * FROM VIDEOS
            INNER JOIN CATEGORIAS_VIDEOS ON
                CATEGORIAS_VIDEOS.ID_VIDEO = VIDEOS.ID_VIDEO
            WHERE
                CATEGORIAS_VIDEOS.ID_CATEGORIA = :ID_CATEGORIA
                AND VIDEOS.STATUS_VIDEO = 1";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_CATEGORIA', $id);

    try{
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeo: " . $e->getMessage());
    }
}

function getReceitas()
{
    $PDO = db_connect();
    $sql = "SELECT * FROM RECEITAS
            ORDER BY RECEITAS.NOME_RECEITA ASC";

    $stmt = $PDO->prepare($sql);

    try{
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar receitas: " . $e->getMessage());
    }
}


function getReceita(int $id)
{

    if (!$id) return false;

    $sql = "SELECT * FROM RECEITAS
            WHERE ID_RECEITA = :ID_RECEITA
            LIMIT 1";

    $PDO = db_connect();
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_RECEITA', $id);

    try{
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar receita: " . $e->getMessage());
    }
}

function getReceitaPorCategoria(int $id)
{
    if (!$id) return false;

    $PDO = db_connect();
    $sql = "SELECT * FROM RECEITAS
            INNER JOIN CATEGORIAS_RECEITAS ON
                RECEITAS.ID_RECEITA = CATEGORIAS_RECEITAS.ID_RECEITA
            WHERE
                CATEGORIAS_RECEITAS.ID_CATEGORIA = :ID_CATEGORIA";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_CATEGORIA', $id);

    try{
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar vídeo: " . $e->getMessage());
    }
}

function getReceitasDestaque()
{
    $PDO = db_connect();
    $sql = "SELECT * FROM RECEITAS
            WHERE RECEITAS.DESTAQUE_RECEITA = 1
            ORDER BY RECEITAS.ID_RECEITA DESC
            LIMIT 3";

    $stmt = $PDO->prepare($sql);

    try{
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar receitas: " . $e->getMessage());
    }
}

function getCategoriaDoVideo($idVideo = null) {

    if (!$idVideo) {
        return false;
    }
    
    $PDO = db_connect();

    $sql = "SELECT * FROM CATEGORIAS_VIDEOS
            INNER JOIN CATEGORIAS ON
                CATEGORIAS.ID_CATEGORIA = CATEGORIAS_VIDEOS.ID_CATEGORIA
            WHERE 
                CATEGORIAS_VIDEOS.ID_VIDEO = :ID_VIDEO LIMIT 1";
    $stmt =$PDO->prepare($sql);
    $stmt->bindParam(':ID_VIDEO', $idVideo, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPrograma($id)
{
	if (empty($id)) {
		return [];
	}

	$PDO = db_connect();
	$sql = "SELECT * FROM PROGRAMAS
			INNER JOIN ETAPAS ON ETAPAS.FK_PROGRAMA = PROGRAMAS.ID_PROGRAMA
			WHERE PROGRAMAS.ID_PROGRAMA = :ID_PROGRAMA
			ORDER BY ETAPAS.ID_ETAPA ASC";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':ID_PROGRAMA', $id);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAulasDoPrograma($id)
{
	$PDO = db_connect();

	$sql = "SELECT * FROM AULAS
			WHERE AULAS.FK_PROGRAMA = :FK_PROGRAMA
			ORDER BY AULAS.ID_AULA";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':FK_PROGRAMA', $id);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function agruparPorAula($aulas)
{
    $newArray = [];

    foreach ($aulas as $aula) {
        $newArray[$aula['FK_ETAPA']][] = $aula;
    }

    return $newArray;
}

function getDadosAula($id, $flReceita = 0)
{
    $PDO = db_connect();

    if ($flReceita) {
        $sql = "SELECT * FROM AULAS
                INNER JOIN RECEITAS
                ON AULAS.REF_AULA = RECEITAS.ID_RECEITA
                WHERE AULAS.FL_RECEITA_AULA = 1 AND  AULAS.ID_AULA = :ID_AULA
                LIMIT 1";
    } else {
        $sql = "SELECT * FROM AULAS
                INNER JOIN VIDEOS
                ON AULAS.REF_AULA = VIDEOS.ID_VIDEO
                WHERE AULAS.FL_RECEITA_AULA = 0 AND AULAS.ID_AULA = :ID_AULA
                LIMIT 1";
    }
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':ID_AULA', $id);
	$stmt->execute();
	return current($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getAulaById($id = null)
{
    if (empty($id)) {
		return [];
	}

	$PDO = db_connect();

	$sql = "SELECT * FROM AULAS
			WHERE AULAS.ID_AULA = :ID_AULA
			LIMIT 1";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':ID_AULA', $id);
	$stmt->execute();
    $result = current($stmt->fetchAll(PDO::FETCH_ASSOC));

    if (!empty($result)) {
        if ($result['FL_RECEITA_AULA']) {
            $sql = "SELECT * FROM AULAS
                    INNER JOIN RECEITAS
                    ON AULAS.REF_AULA = RECEITAS.ID_RECEITA
                    WHERE AULAS.FL_RECEITA_AULA = 1 AND  AULAS.ID_AULA = :ID_AULA
                    LIMIT 1";
        } else {
            $sql = "SELECT * FROM AULAS
                    INNER JOIN VIDEOS
                    ON AULAS.REF_AULA = VIDEOS.ID_VIDEO
                    WHERE AULAS.FL_RECEITA_AULA = 0 AND AULAS.ID_AULA = :ID_AULA
                    LIMIT 1";
        }
        
        $stmt = $PDO->prepare($sql);
        $stmt->bindValue(':ID_AULA', $id);
        $stmt->execute();
        return current($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}

function getDadosProximaAula($arrAulas, $id)
{
    $next = [];
    $last = array_key_last($arrAulas);

    foreach ($arrAulas as $key => $aula) {
        $proximaAula = $key + 1;
        if ($key == $last) {
            $next = [
                'FL_CONCLUIR' => 1,
                'ID_AULA' => null
            ];

            return $next;
        }

        if ($aula['ID_AULA'] == $id) {
            $next = [
                'FL_CONCLUIR' => 0,
                'ID_AULA' => $arrAulas[$proximaAula]['ID_AULA']
            ];

            return $next;
        }
    }
}

function getAulaAtualDoUsuario($idUsuario, $idPrograma = null)
{
    if (empty($idUsuario)) {
        return false;
    }

	if (empty($idPrograma)) {
		return [
            'AULA_ATUAL' => 1,
            'ETAPA' => 1,
            'FL_CONCLUIDO' => 0
        ];
	}

	$PDO = db_connect();
	$sql = "SELECT * FROM PROGRESSO_USUARIO
			WHERE PROGRESSO_USUARIO.FK_USUARIO = :FK_USUARIO AND PROGRESSO_USUARIO.FK_PROGRAMA = :FK_PROGRAMA
			ORDER BY PROGRESSO_USUARIO.ID_PROGRESSO ASC";
	
	$stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_USUARIO', $idUsuario);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
	$stmt->execute();
    $result = current($stmt->fetchAll(PDO::FETCH_ASSOC));
    
    if (empty($result)) {
		return [
            'AULA_ATUAL' => 1,
            'ETAPA' => 1,
            'FL_CONCLUIDO' => 0
        ];
    }

    $phpdate = strtotime($result['DT_CONCLUSAO']);
    $dtEtapa = date('Y-m-d', $phpdate);
    $dtAtual = date('Y-m-d');

    if (strtotime($dtAtual) > strtotime($dtEtapa)) {
        $result['FK_ETAPA'] = $result['FK_ETAPA'] + 1;
    }

    return [
        'AULA_ATUAL' => 1,
        'ETAPA' => $result['FK_ETAPA'],
        'FL_CONCLUIDO' => 1
    ];
}

function getNavegacaoPrograma($idPrograma)
{
    if (empty($idPrograma)) {
        return [];
    }

    $sql = "SELECT * FROM ETAPAS
            INNER JOIN AULAS
            ON AULAS.FK_ETAPA = ETAPAS.ID_ETAPA
            WHERE AULAS.FK_PROGRAMA = :FK_PROGRAMA
            ORDER BY ETAPAS.ID_ETAPA ASC";

    $PDO = db_connect();
    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        return $result;
    }

    $newArray = [];
    foreach ($result as $programa) {
        $newArray[$programa['ID_ETAPA']]['ID_ETAPA'] = $programa['ID_ETAPA'];
        $newArray[$programa['ID_ETAPA']]['NOME_ETAPA'] = $programa['NOME_ETAPA'];
        $newArray[$programa['ID_ETAPA']]['FL_PREMIO_ETAPA'] = $programa['NOME_ETAPA'];
        $newArray[$programa['ID_ETAPA']]['AULAS'][$programa['ID_AULA']]['ID_AULA'] = $programa['ID_AULA'];
        $newArray[$programa['ID_ETAPA']]['AULAS'][$programa['ID_AULA']]['REF_AULA'] = $programa['REF_AULA'];
        $newArray[$programa['ID_ETAPA']]['AULAS'][$programa['ID_AULA']]['FL_RECEITA_AULA'] = $programa['FL_RECEITA_AULA'];
    }

    return $newArray;
}

/*
 * Melhoria de performance
 */
function getNavegacaoProgramaV2($idPrograma)
{
    if (empty($idPrograma)) {
        return [];
    }

    $sql = "SELECT * FROM ETAPAS
            INNER JOIN AULAS
            ON AULAS.FK_ETAPA = ETAPAS.ID_ETAPA
            LEFT JOIN VIDEOS
                ON VIDEOS.ID_VIDEO = AULAS.REF_AULA
                AND AULAS.FL_RECEITA_AULA = 0
            LEFT JOIN RECEITAS
                ON RECEITAS.ID_RECEITA = AULAS.REF_AULA
                AND AULAS.FL_RECEITA_AULA = 1
            WHERE AULAS.FK_PROGRAMA = :FK_PROGRAMA
            ORDER BY ETAPAS.ID_ETAPA ASC";

    $PDO = db_connect();
    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        return $result;
    }

    $newArray = [];
    foreach ($result as $programa) {
        $newArray[$programa['ID_ETAPA']]['ID_ETAPA'] = $programa['ID_ETAPA'];
        $newArray[$programa['ID_ETAPA']]['NOME_ETAPA'] = $programa['NOME_ETAPA'];
        $newArray[$programa['ID_ETAPA']]['FL_PREMIO_ETAPA'] = $programa['FL_PREMIO_ETAPA'];
        $newArray[$programa['ID_ETAPA']]['AULAS'][$programa['ID_AULA']]['ID_AULA'] = $programa['ID_AULA'];
        $newArray[$programa['ID_ETAPA']]['AULAS'][$programa['ID_AULA']]['REF_AULA'] = $programa['REF_AULA'];
        $newArray[$programa['ID_ETAPA']]['AULAS'][$programa['ID_AULA']]['FL_RECEITA_AULA'] = $programa['FL_RECEITA_AULA'];
        $newArray[$programa['ID_ETAPA']]['AULAS'][$programa['ID_AULA']]['NOME'] = ($programa['FL_RECEITA_AULA']) ? $programa['NOME_RECEITA'] : $programa['NOME_VIDEO'];
        $newArray[$programa['ID_ETAPA']]['AULAS'][$programa['ID_AULA']]['LINK_VIDEO'] = $programa['LINK_VIDEO'];
        $newArray[$programa['ID_ETAPA']]['AULAS'][$programa['ID_AULA']]['DESCRICAO_RECEITA'] = $programa['DESCRICAO_RECEITA'];
        $newArray[$programa['ID_ETAPA']]['AULAS'][$programa['ID_AULA']]['FK_ETAPA'] = $programa['FK_ETAPA'];
        $newArray[$programa['ID_ETAPA']]['AULAS'][$programa['ID_AULA']]['FK_PROGRAMA'] = $programa['FK_PROGRAMA'];
    }

    return $newArray;
}

function getAulaNavegacao($arAulas = [])
{
    if (empty($arAulas)) {
        return $arAulas;
    }

    $newArray = [];
    foreach ($arAulas as $aula) {
        $newArray[$aula['ID_AULA']] = getDadosDaAula($aula['ID_AULA'], $aula['FL_RECEITA_AULA']);
    }

    return $newArray;
}

function getDadosDaAula($idAula, $flReceita)
{
    $PDO = db_connect();
    
    if ($flReceita) {
        $sql = "SELECT * FROM AULAS
                INNER JOIN RECEITAS
                ON AULAS.REF_AULA = RECEITAS.ID_RECEITA
                WHERE AULAS.FL_RECEITA_AULA = 1 AND  AULAS.ID_AULA = :ID_AULA
                LIMIT 1";
    } else {
        $sql = "SELECT * FROM AULAS
                INNER JOIN VIDEOS
                ON AULAS.REF_AULA = VIDEOS.ID_VIDEO
                WHERE AULAS.FL_RECEITA_AULA = 0 AND AULAS.ID_AULA = :ID_AULA
                LIMIT 1";
    }
    
    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':ID_AULA', $idAula);
    $stmt->execute();
    
    return current($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getConteudoAulaId($id)
{
	$PDO = db_connect();

	$sql = "SELECT * FROM ETAPAS
            INNER JOIN AULAS ON AULAS.FK_ETAPA = ETAPAS.ID_ETAPA
            WHERE AULAS.ID_AULA = :ID_AULA";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':ID_AULA', $id);
	$stmt->execute();
    $result = current($stmt->fetchAll(PDO::FETCH_ASSOC));

    if (!empty($result)) {
        if ($result['FL_RECEITA_AULA']) {
            $sql = "SELECT * FROM AULAS
                    INNER JOIN RECEITAS
                    ON AULAS.REF_AULA = RECEITAS.ID_RECEITA
                    WHERE AULAS.FL_RECEITA_AULA = 1 AND  AULAS.ID_AULA = :ID_AULA
                    LIMIT 1";
        } else {
            $sql = "SELECT * FROM AULAS
                    INNER JOIN VIDEOS
                    ON AULAS.REF_AULA = VIDEOS.ID_VIDEO
                    WHERE AULAS.FL_RECEITA_AULA = 0 AND AULAS.ID_AULA = :ID_AULA
                    LIMIT 1";
        }
        
        $stmt = $PDO->prepare($sql);
        $stmt->bindValue(':ID_AULA', $id);
        $stmt->execute();
        $arAulas = current($stmt->fetchAll(PDO::FETCH_ASSOC));

        return array_merge($result, $arAulas);
    }
}
function getPrimeiraAula($idPrograma)
{
    $PDO = db_connect();

    $sql = "SELECT AULAS.ID_AULA
            FROM AULAS
            WHERE AULAS.FK_PROGRAMA = :FK_PROGRAMA
            AND FK_ETAPA = 1
            ORDER BY AULAS.ID_AULA
            LIMIT 1";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->execute();
    return current($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getSegundaAula($idPrograma)
{
    $PDO = db_connect();

    $sql = "SELECT AULAS.ID_AULA, AULAS.FK_ETAPA
            FROM AULAS
            WHERE AULAS.FK_PROGRAMA = :FK_PROGRAMA
            AND FK_ETAPA = 1
            ORDER BY AULAS.ID_AULA DESC
            LIMIT 2";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProximaAula($idPrograma, $idEtapa)
{
    $PDO = db_connect();

    $sql = "SELECT * FROM ETAPAS
            INNER JOIN AULAS ON ETAPAS.ID_ETAPA = AULAS.FK_ETAPA
            WHERE ETAPAS.FK_PROGRAMA = :FK_PROGRAMA AND ETAPAS.ID_ETAPA = :ID_ETAPA";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->bindValue(':ID_ETAPA', $idEtapa);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getNavegacaoProximaAula($idPrograma, $idAula, $idEtapa = null)
{
    if (empty($idEtapa)) {
        $arSegundaAula = getSegundaAula($idPrograma);

        if (empty($arSegundaAula)) {
            return [];
        }

        if (count($arSegundaAula) > 1) {
            return [
                'ID_AULA' => $arSegundaAula[0]['ID_AULA'],
                'ID_ETAPA' => $arSegundaAula[0]['FK_ETAPA'],
                'FL_COMPLETO' => 0
            ];
        }

        return [
            'ID_AULA' => $arSegundaAula[0]['ID_AULA'],
            'ID_ETAPA' => $arSegundaAula[0]['FK_ETAPA'],
            'FL_COMPLETO' => 1
        ];
    }

    $arProxima = getProximaAula($idPrograma, $idEtapa);

    $keyAulaAtual = 0;
    foreach ($arProxima as $key => $proxima) {
        if ($proxima['ID_AULA'] == $idAula) {
            $keyAulaAtual = $key;
        }
    }

    if (!empty($arProxima[$keyAulaAtual + 1])) {
        return [
            'ID_AULA' => $arProxima[$keyAulaAtual + 1]['ID_AULA'],
            'ID_ETAPA' => $arProxima[$keyAulaAtual + 1]['FK_ETAPA'],
            'FL_COMPLETO' => 0
        ];
    }

    if (empty($arProxima[$keyAulaAtual + 1])) {
        $idProximaEtapa = $arProxima[$keyAulaAtual]['FK_ETAPA'] + 1;
        $idPrimeiraAula = getPrimeiraAulaDaEtapa($idPrograma, $idProximaEtapa);
        return [
            'ID_AULA' => $idPrimeiraAula['ID_AULA'],
            'ID_ETAPA' => $idProximaEtapa,
            'FL_COMPLETO' => 1
        ];
    }
}

function getUrlProximaAula($dados = [])
{
    if (empty($dados)) {
        return false;
    }

    if ($dados['FL_COMPLETO']) {
        return "/programa.php?programa=1&etapa=".$dados['ID_ETAPA']."&aula=".$dados['ID_AULA']."&completo=1";
    }

    return "/programa.php?programa=1&etapa=".$dados['ID_ETAPA']."&aula=".$dados['ID_AULA'];
}

function getPrimeiraAulaDaEtapa($idPrograma, $idEtapa)
{
    $PDO = db_connect();

    $sql = "SELECT AULAS.ID_AULA
            FROM AULAS
            WHERE AULAS.FK_PROGRAMA = :FK_PROGRAMA
            AND FK_ETAPA = :FK_ETAPA
            ORDER BY AULAS.ID_AULA
            LIMIT 1";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->bindValue(':FK_ETAPA', $idEtapa);
    $stmt->execute();
    return current($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function redirecionarParaPrograma($idPrograma, $idUsuario)
{
    $PDO = db_connect();

    $sql = "SELECT * FROM
                PROGRESSO_PROGRAMA
            WHERE
                FK_PROGRAMA = :FK_PROGRAMA
            AND
                FK_USUARIO = :FK_USUARIO";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->bindValue(':FK_USUARIO', $idUsuario);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($result)) {
        $sql = "INSERT INTO PROGRESSO_PROGRAMA
                (FK_PROGRAMA, FK_USUARIO) VALUES (:FK_PROGRAMA, :FK_USUARIO)";

        $stmt = $PDO->prepare($sql);
        $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
        $stmt->bindValue(':FK_USUARIO', $idUsuario);
        $stmt->execute();
        
        return false;
    }

    return true;
}

function getMeuLikeNaAula($idAula, $idUsuario)
{
    $PDO = db_connect();

    $sql = "SELECT NM_LIKE FROM LIKE_AULA WHERE FK_USUARIO = :FK_USUARIO AND FK_AULA = :FK_AULA";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_USUARIO', $idUsuario);
    $stmt->bindValue(':FK_AULA', $idAula);
    $stmt->execute();
    return current($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function setProgressoUsuario($idUsuario, $idPrograma, $idEtapa)
{
    if (!empty(verificarProgressoUsuario($idUsuario, $idPrograma, $idEtapa))) {
        return true;
    }

    $PDO = db_connect();

    $sql = "INSERT INTO
                PROGRESSO_USUARIO (FK_ETAPA, FK_PROGRAMA, FK_USUARIO)
            VALUES (:FK_ETAPA, :FK_PROGRAMA, :FK_USUARIO)";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_USUARIO', $idUsuario);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->bindValue(':FK_ETAPA', $idEtapa);
    $stmt->execute();
}

function verificarProgressoUsuario($idUsuario, $idPrograma, $idEtapa)
{
    $PDO = db_connect();

    $sql = "SELECT * FROM
                PROGRESSO_USUARIO
            WHERE
                FK_PROGRAMA = :FK_PROGRAMA
                AND FK_ETAPA = :FK_ETAPA
                AND FK_USUARIO = :FK_USUARIO";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->bindValue(':FK_ETAPA', $idEtapa);
    $stmt->bindValue(':FK_USUARIO', $idUsuario);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getEtapasCompletas($idUsuario, $idPrograma)
{
    $PDO = db_connect();

    $sql = "SELECT FK_ETAPA FROM
                PROGRESSO_USUARIO
            WHERE
                FK_PROGRAMA = :FK_PROGRAMA
                AND FK_USUARIO = :FK_USUARIO";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->bindValue(':FK_USUARIO', $idUsuario);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $newArray = [];
    
    if (!empty($result)) {
        foreach ($result as $etapa) {
            $newArray[] = $etapa['FK_ETAPA'];
        }
    }

    return $newArray;
}

function getIconEtapaCompleta($idPrograma)
{
    $PDO = db_connect();

    $sql = "SELECT * FROM ETAPAS WHERE FK_PROGRAMA = :FK_PROGRAMA";
    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->execute();
    $arIcons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $icons = [];

    if (empty($arIcons)) {
        return $icons;
    }

    foreach ($arIcons as $etapa) {
        if ($etapa['FL_PREMIO_ETAPA']) {
            $icons[$etapa['ID_ETAPA']] = './uploads/' . $etapa['ICON_ETAPA'];
        }
    }

    return $icons;
}

function getModalPersonalizado($idPrograma)
{
    $PDO = db_connect();

    $sql = "SELECT * FROM ETAPAS WHERE FK_PROGRAMA = :FK_PROGRAMA";
    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->execute();
    $arIcons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $icons = [];

    if (empty($arIcons)) {
        return $icons;
    }

    foreach ($arIcons as $etapa) {
        if ($etapa['FL_PREMIO_ETAPA']) {
            $icons[$etapa['ID_ETAPA']] = './uploads/' . $etapa['POPUP_ETAPA'];
        }
    }

    return $icons;
}

function getIdModalPersonalizado($idPrograma, $idEtapa)
{
    $PDO = db_connect();

    $idEtapa--;

    $sql = "SELECT ID_ETAPA FROM
                ETAPAS
            WHERE
                FK_PROGRAMA = :FK_PROGRAMA
                AND ID_ETAPA = :ID_ETAPA
                AND FL_PREMIO_ETAPA = 1";

    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
    $stmt->bindValue(':ID_ETAPA', $idEtapa);
    $stmt->execute();

    return current($stmt->fetchAll(PDO::FETCH_ASSOC));
}
