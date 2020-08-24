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
	<nav class="nav py-3 bg-dark text-light mb-4">
		<div class="container">
			<div class="d-flex justify-content-between">
				<div><code>Página inicial</code></div>
				<div><a href="/logout.php">logout</a></div>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
			<?php $a = 1; while ($a <= 12) : ?>
			<div class="col">
				<div class="card mb-3">
					<div class="card-body">
						<div class="mb-3">
						<code>Vídeo <?= $a; ?></code>
						</div>
						<a href="/video.php?watch=<?= md5($a); ?>"
							id="assistir-video"
							class="btn btn-primary btn-sm"
							onclick="dataLayer.push({'nome': 'Vídeo <?= $a; ?>','usuario': 'NomeDoUsuario', 'empresa': 'Nome da empresa','event': 'assistir'});">
							Assistir
						</a>
					</div>
				</div>
			</div>
			<?php $a++; endwhile; ?>
		</div>
	</div>
</main>

<?php
$_footer = '_footer.php';
include($_footer);
?>