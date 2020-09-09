<?php
require('control.php');
require('_header.php');

$page = [];

$idCategoria = $_GET['categoria'] ?: null;

if ($_SESSION['empresa']) {
	$page = getPageCompany($_SESSION['empresa'], $idCategoria);
}
?>

<main>
    <nav class="navbar navbar-expand-md navbar-light bg-white">
		<div class="container">
			<a href="/" class="navbar-brand">WoW Life</a>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a href="/" class="nav-link">Home</a>
				</li>
				<li class="nav-item active">
					<a href="./aulas.php" class="nav-link">Aulas</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link text-decoration-none dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
						<i class="far fa-user-circle text-primary"></i>
						<span class="sr-only"><?= $_SESSION['usuario']; ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="/logout.php">Sair</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container py-3 mb-5">
		<?php if (!empty($page)) : ?>
		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
			<?php foreach ($page as $video) : ?>
			<div class="col">
				<div class="card card-video mb-3">
					<?php if ($video['THUMB_VIDEO']) : ?>
					<a
						id="assistir-video"
						href="./video.php?v=<?= $video['ID_VIDEO']; ?>"
						class="text-decoration-none"
						data-empresa="<?= $video['NOME_EMPRESA']; ?>"
						data-video="<?= $video['NOME_VIDEO']; ?>">
						<img src="./uploads/<?= $video['THUMB_VIDEO']; ?>" class="card-img-top img-cover" alt="<?= $video['NOME_VIDEO']; ?>">
					</a>
					<?php endif; ?>
					<div class="card-body">
						<h5 class="card-title text-center text-primary mb-0">
							<a
								id="assistir-video"
								href="./video.php?v=<?= $video['ID_VIDEO']; ?>"
								class="text-decoration-none"
								data-empresa="<?= $video['NOME_EMPRESA']; ?>"
								data-video="<?= $video['NOME_VIDEO']; ?>">
								<?= $video['NOME_VIDEO']; ?>
							</a>
						</h5>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php else: ?>
		<div class="alert alert-warning">Nenhum resultado</div>
		<?php endif; ?>
	</div>
</main>

<?php require('_footer.php'); ?>