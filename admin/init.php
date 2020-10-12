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