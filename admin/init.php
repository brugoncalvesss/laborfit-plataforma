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