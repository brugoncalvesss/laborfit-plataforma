<?php
session_start();
require_once './functions.php';

$redirect = base64_decode($_GET['q']);
$arrProgresso = explode('=', $redirect);
$idPrograma = $arrProgresso[1];
$idEtapa = $arrProgresso[2] - 1;
$idUsuario = $_COOKIE['USUARIO_ID'];

setProgressoUsuario($idUsuario, $idPrograma, $idEtapa);
header('Location: '. $redirect);
exit;
?>
