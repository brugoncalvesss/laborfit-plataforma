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

function limparCaracteres($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}