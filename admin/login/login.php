<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['nome'] = '$nomeDoUsuario';
$_SESSION['id_empresa'] = session_create_id();
header("location: /admin/empresass/");
exit();