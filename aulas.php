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
			<a href="/" class="navbar-brand">
				<img src="./img/logo.png" alt="Logo WoW Life" height="60">
			</a>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link text-decoration-none dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
						<img src="./img/user.png" alt="Perfil">
						<span id="usuario" class="sr-only"><?= $_SESSION['usuario']; ?></span>
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
				<div class="card card-video mb-4">
					<?php if ($video['THUMB_VIDEO']) : ?>
					<div class="card-cover">
						<a id="ver-video" href="./video.php?v=<?= $video['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $video['NOME_EMPRESA']; ?>" data-video="<?= $video['NOME_VIDEO']; ?>" data-usuario="<?= $_SESSION['usuario']; ?>">
							<img src="./uploads/<?= $video['THUMB_VIDEO']; ?>" class="img-cover" alt="<?= $video['NOME_VIDEO']; ?>">
						</a>
					</div>
					<?php endif; ?>
					<div class="card-body">
						<h5 class="card-title text-center text-primary mb-0">
							<a id="ver-video" href="./video.php?v=<?= $video['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $video['NOME_EMPRESA']; ?>" data-video="<?= $video['NOME_VIDEO']; ?>" data-usuario="<?= $_SESSION['usuario']; ?>">
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