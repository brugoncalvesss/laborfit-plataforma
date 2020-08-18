<?php
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
$componente = $uri_segments[2];

if ($componente) {
	$page = './'.$componente.'/index.php';
} else {
	$page = './dashboard/index.php';
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
<?php
try {
	if (file_exists($page)) {
		include($page);
	} else {
		throw new Exception("Arquivo não existe.");
	}
} catch (Exception $e) {
	echo 'Erro: ',  $e->getMessage(), "\n";
}
?>
</main>