<?php
$_header = '_header.php';
include($_header);

if (!$_SESSION) {
	header("location: /login.php");
	exit();
}

$page = [];

if ($_SESSION['empresa']) {
	$page = getPageCompany($_SESSION['empresa']);
}

?>

<main>
	<div class="container">
		<code>Página inicial</code>
		<a href="/logout.php">logout</a>
	</div>
</main>

<?php
$_footer = '_footer.php';
include($_footer);
?>