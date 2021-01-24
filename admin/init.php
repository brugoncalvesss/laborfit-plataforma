<?php

// MySQL
define('DB_HOST', '192.185.213.43');
define('DB_USER', 'wowlif90_prod');
define('DB_PASS', '^R[7LWG!8xI7');
define('DB_NAME', 'wowlif90_plataforma');

function limparCaracteres($valor) {
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

function formatCnpjCpf($value)
{
  $cnpj_cpf = preg_replace("/\D/", '', $value);
  
  if (strlen($cnpj_cpf) === 11) {
	return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  } 
  
  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function getSelectEmpresas(int $id = null) {
	$PDO = db_connect();

	$sql = "SELECT ID_EMPRESA, NOME_EMPRESA FROM EMPRESAS";
	$request = $PDO->prepare($sql);
	$request->execute();
	$empresas = $request->fetchAll(PDO::FETCH_ASSOC);

	if (!empty($empresas)) {
		foreach ($empresas as $empresa) {
			$selected = false;
			if ($id && ($empresa['ID_EMPRESA'] == $id)) {
				$selected = 'selected';
			}
			$option = "<option {$selected} value='{$empresa['ID_EMPRESA']}'>{$empresa['NOME_EMPRESA']}</option>";
			echo $option;
		}
	}
}

function carregarSelectAlbuns(int $idAlbum = null) {
	$PDO = db_connect();

	$sql = "SELECT * FROM
				CATEGORIAS
			ORDER BY
				NOME_CATEGORIA
			ASC";
	$stmt = $PDO->prepare($sql);
	$stmt->execute();
	$albuns = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (!empty($albuns)) {
		foreach ($albuns as $album) {
			$selected = false;
			if ($idAlbum && ($album['ID_CATEGORIA'] == $idAlbum)) {
				$selected = 'selected';
			}
			$option = "<option {$selected} value='{$album['ID_CATEGORIA']}'>{$album['NOME_CATEGORIA']}</option>";
			echo $option;
		}
	}
}

function carregarSelectEmpresas(int $idEmpresa = null)
{
	$PDO = db_connect();

	$sql = "SELECT * FROM EMPRESAS
			ORDER BY
				NOME_EMPRESA
			ASC";
	$stmt = $PDO->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (!empty($result)) {
		foreach ($result as $empresa) {
			$selected = false;
			if ($idEmpresa && ($empresa['ID_EMPRESA'] == $idEmpresa)) {
				$selected = 'selected';
			}
			$option = "<option {$selected} value='{$empresa['ID_EMPRESA']}'>{$empresa['NOME_EMPRESA']}</option>";
			echo $option;
		}
	}
}

function verificaCpfUsuarioExistente($cpf)
{
	if (!$cpf) {
		return false;
	}

	$PDO = db_connect();
	$sql = "SELECT COUNT(ID_USUARIO) FROM USUARIOS WHERE CPF_USUARIO = :CPF_USUARIO LIMIT 1";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':CPF_USUARIO', $cpf);
	$stmt->execute();
	
	if ($stmt->fetchColumn()) {
		return 1;
	}

	return 0;
}


function verificaIdEmpresa($empresa)
{
	if (!$empresa) {
		return 0;
	}

	$PDO = db_connect();
	$sql = "SELECT ID_EMPRESA FROM EMPRESAS
			WHERE NOME_EMPRESA LIKE :NOME_EMPRESA   
			LIMIT 1";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':NOME_EMPRESA', '%'.$empresa.'%');
	
	if ($stmt->execute()) {
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	return 0;
}

function carregarCategorias(int $idCategoria = null) {
	$PDO = db_connect();

	$sql = "SELECT * FROM
				CATEGORIAS
			ORDER BY
				NOME_CATEGORIA
			ASC";
	$stmt = $PDO->prepare($sql);
	$stmt->execute();
	$albuns = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (!empty($albuns)) {
		foreach ($albuns as $album) {
			$selected = false;
			if ($idAlbum && ($album['ID_CATEGORIA'] == $idAlbum)) {
				$selected = 'selected';
			}
			$option = "<option {$selected} value='{$album['ID_CATEGORIA']}'>{$album['NOME_CATEGORIA']}</option>";
			echo $option;
		}
	}
}

function getIdPorNomeCategoria(string $categoria)
{
	if (!$categoria) {
		return 0;
	}

	$PDO = db_connect();
	$sql = "SELECT ID_CATEGORIA FROM CATEGORIAS
			WHERE NOME_CATEGORIA LIKE :NOME_CATEGORIA   
			LIMIT 1";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':NOME_CATEGORIA', '%'.$categoria.'%');
	
	if ($stmt->execute()) {
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	return 0;
}


function getIdPorNomeTema(string $tema)
{
	if (!$tema) {
		return 0;
	}

	$PDO = db_connect();
	$sql = "SELECT ID_TEMA FROM TEMAS
			WHERE NOME_TEMA LIKE :NOME_TEMA   
			LIMIT 1";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':NOME_TEMA', '%'.$tema.'%');
	
	if ($stmt->execute()) {
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	return 0;
}

function deleteCategoriaPorIdVideo(int $id)
{
	if (!$id)  return 0;
	
	$PDO = db_connect();
	$sql = "DELETE FROM CATEGORIAS_VIDEOS WHERE ID_VIDEO = :ID_VIDEO";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':ID_VIDEO', $id);
	
	if ($stmt->execute()) {
		return 1;
	}

	return 0;
}

function deleteTemaPorIdVideo(int $id)
{
	if (!$id)  return 0;
	
	$PDO = db_connect();
	$sql = "DELETE FROM TEMAS_VIDEOS WHERE ID_VIDEO = :ID_VIDEO";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':ID_VIDEO', $id);
	
	if ($stmt->execute()) {
		return 1;
	}

	return 0;
}

function getCategoriasByIdVideo(int $id)
{
	if (!$id)  return 0;

	$PDO = db_connect();
	$sql = "SELECT * FROM CATEGORIAS
			INNER JOIN CATEGORIAS_VIDEOS ON
				CATEGORIAS_VIDEOS.ID_CATEGORIA = CATEGORIAS.ID_CATEGORIA
			WHERE
				CATEGORIAS_VIDEOS.ID_VIDEO = :ID_VIDEO";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':ID_VIDEO', $id, PDO::PARAM_INT);
	
	if ($stmt->execute()) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	return 0;
}

function getTemasByIdVideo(int $id)
{
	if (!$id)  return 0;

	$PDO = db_connect();
	$sql = "SELECT * FROM TEMAS
			INNER JOIN TEMAS_VIDEOS ON
				TEMAS_VIDEOS.ID_TEMA = TEMAS.ID_TEMA
			WHERE
				TEMAS_VIDEOS.ID_VIDEO = :ID_VIDEO";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':ID_VIDEO', $id, PDO::PARAM_INT);
	
	if ($stmt->execute()) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	return 0;
}

function getCategoriasByIdReceita(int $id)
{
	if (!$id)  return 0;

	$PDO = db_connect();
	$sql = "SELECT * FROM CATEGORIAS
			INNER JOIN CATEGORIAS_RECEITAS ON
				CATEGORIAS_RECEITAS.ID_CATEGORIA = CATEGORIAS.ID_CATEGORIA
			WHERE
				CATEGORIAS_RECEITAS.ID_RECEITA = :ID_RECEITA";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':ID_RECEITA', $id, PDO::PARAM_INT);
	
	if ($stmt->execute()) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	return 0;
}

function deleteCategoriaPorIdReceita(int $id)
{
	if (!$id)  return 0;
	
	$PDO = db_connect();
	$sql = "DELETE FROM CATEGORIAS_RECEITAS WHERE ID_RECEITA = :ID_RECEITA";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':ID_RECEITA', $id);
	
	if ($stmt->execute()) {
		return 1;
	}

	return 0;
}

function getOptionsDestaqueVideo($id = null)
{
	$PDO = db_connect();

	$sql = "SELECT * FROM DESTAQUES WHERE ID_DESTAQUE != 1 ORDER BY NOME_DESTAQUE ASC";
	$stmt = $PDO->prepare($sql);
	$stmt->execute();
	$arDestaques = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (!empty($arDestaques)) {
		foreach ($arDestaques as $destaque) {
			$selected = false;
			if ($id && ($destaque['ID_DESTAQUE'] == $id)) {
				$selected = 'selected';
			}
			$option = "<option {$selected} value='{$destaque['ID_DESTAQUE']}'>{$destaque['NOME_DESTAQUE']}</option>";
			echo $option;
		}
	}
}

function getOptionsDestaqueReceita($id = null)
{
	$PDO = db_connect();

	$sql = "SELECT * FROM DESTAQUES WHERE ID_DESTAQUE = 1 ORDER BY NOME_DESTAQUE ASC";
	$stmt = $PDO->prepare($sql);
	$stmt->execute();
	$arDestaques = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (!empty($arDestaques)) {
		foreach ($arDestaques as $destaque) {
			$selected = false;
			if ($id && ($destaque['ID_DESTAQUE'] == $id)) {
				$selected = 'selected';
			}
			$option = "<option {$selected} value='{$destaque['ID_DESTAQUE']}'>{$destaque['NOME_DESTAQUE']}</option>";
			echo $option;
		}
	}
}

function getIdDestaqueVideo($id)
{
	if (!$id) return 0;
	
	$PDO = db_connect();
	$sql = "SELECT ID_DESTAQUE FROM DESTAQUES_VIDEOS WHERE ID_VIDEO = :ID_VIDEO";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':ID_VIDEO', $id);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getEtapasDoPrograma($id = null)
{
	if (empty($id)) {
		return [];
	}

	$PDO = db_connect();
	$sql = "SELECT * FROM ETAPAS WHERE FK_PROGRAMA = :FK_PROGRAMA";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':FK_PROGRAMA', $id);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPrograma($id = null)
{
	$PDO = db_connect();

	$sql = "SELECT * FROM PROGRAMAS ORDER BY PROGRAMAS.NOME_PROGRAMA";
	
	if ($id) {
		$sql = "SELECT * FROM
				PROGRAMAS
				WHERE PROGRAMAS.ID_PROGRAMA = :ID_PROGRAMA
				ORDER BY PROGRAMAS.NOME_PROGRAMA";
	}
	
	$stmt = $PDO->prepare($sql);

	if ($id) {
		$stmt->bindValue(':ID_PROGRAMA', $id);
	}

	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAulaDoPrograma($id = null)
{
	if (empty($id)) {
		return [];
	}

	$PDO = db_connect();

	$sql = "SELECT * FROM AULAS
			WHERE AULAS.REF_AULA = :REF_AULA AND AULAS.FL_RECEITA_AULA = 0
			ORDER BY AULAS.ID_AULA";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':REF_AULA', $id);
	$stmt->execute();
	return current($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getReceitaDoPrograma($id = null)
{
	if (empty($id)) {
		return [];
	}

	$PDO = db_connect();

	$sql = "SELECT * FROM AULAS
			WHERE AULAS.REF_AULA = :REF_AULA AND AULAS.FL_RECEITA_AULA = 1
			ORDER BY AULAS.ID_AULA";
	
	$stmt = $PDO->prepare($sql);
	$stmt->bindValue(':REF_AULA', $id);
	$stmt->execute();
	return current($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getEtapa($idEtapa, $idPrograma)
{
	$PDO = db_connect();
	$sql = "SELECT * FROM ETAPAS WHERE ID_ETAPA = :ID_ETAPA AND FK_PROGRAMA = :FK_PROGRAMA;";
	
	$stmt = $PDO->prepare($sql);
    $stmt->bindValue(':ID_ETAPA', $idEtapa);
    $stmt->bindValue(':FK_PROGRAMA', $idPrograma);
	$stmt->execute();
	return current($stmt->fetchAll(PDO::FETCH_ASSOC));
}