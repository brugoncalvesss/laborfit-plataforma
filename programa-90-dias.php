<?php
session_start();
require_once './functions.php';

$idPrograma = $_GET['programa'] ?: 1;

$redirecionarParaPrograma = redirecionarParaPrograma($idPrograma, $_SESSION['USUARIO_ID']);
if ($redirecionarParaPrograma) {
	$url = "/programa.php?programa=".$idPrograma;
	header('Location: '. $url, true);
	exit;
}

$url = "/introducao.php?programa=".$idPrograma;
header('Location: '. $url, true);
exit;

require('_footer.php');
?>