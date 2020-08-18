<?php
$_header = $_SERVER['DOCUMENT_ROOT'] . '/admin/_header.php';
include($_header);

$header = $_SERVER['DOCUMENT_ROOT'] . '/admin/header.php';
include($header);

$header = $_SERVER['DOCUMENT_ROOT'] . '/admin/sidebar.php';
include($header);

$route = $_SERVER['DOCUMENT_ROOT'] . '/admin/route.php';
include($route);

$footer = $_SERVER['DOCUMENT_ROOT'] . '/admin/footer.php';
include($footer);

$_footer = $_SERVER['DOCUMENT_ROOT'] . '/admin/_footer.php';
include($_footer);
