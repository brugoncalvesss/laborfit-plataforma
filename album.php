<?php
require('control.php');
require('_header.php');

$idAlbum = $_GET['q'] ?: null;

if (!$idAlbum) {
	die("Erro: Não foi informado o álbum.");
}

$arVideos = getAlbum($idAlbum);
$categoria = getCategoria($idAlbum);
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
						<span id="usuario" class="sr-only"><?= $usuario['NOME_USUARIO']; ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="/logout.php">Sair</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>

	<?php if ($categoria) : ?>
	<header class="video-header bg-wave-primary text-light text-center py-4">
		<h1 class="text-light font-weight-600 mt-2">
			<?= $categoria['NOME_CATEGORIA']; ?>
		</h1>
		<h2 class="h4"><?= $categoria['DESC_CATEGORIA']; ?></h2>
	</header>

	<section class="video-content">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-10 offset-md-1">
					<div class="card card-destaque border-0">
						<div class="video-border bg-dark">
							<img src="./uploads/<?= $categoria['IMG_CATEGORIA']; ?>" class="img-fluid cover">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ($arVideos): ?>
	<section id="videos" class="videos py-5">
		<div class="container">
			
			<div class="mb-5 text-center">
				<div class="d-block mb-2">
					<h4 class="h6 title-line">Lista de vídeos WOW!</h4>
				</div>
				<div class="d-inline-block rounded-pill bg-primary text-light font-weight-800 px-4 py-3">
					Faça um filtro por tema <i class="fas fa-chevron-down pl-1"></i>
				</div>
			</div>

			<?php if (!empty($arVideos)) : ?>
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">

				<?php foreach ($arVideos as $video) : ?>
				<div class="col">
					<div class="card card-video mb-3">
						<?php if ($video['THUMB_VIDEO']) : ?>
						<div class="card-cover">
							<a id="ver-video" href="./video.php?v=<?= $video['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $_SESSION['EMPRESA_USUARIO']; ?>" data-video="<?= $video['NOME_VIDEO']; ?>" data-usuario="<?= $_SESSION['NOME_USUARIO']; ?>">
								<img src="./uploads/<?= $video['THUMB_VIDEO']; ?>" class="img-cover" alt="<?= $video['NOME_VIDEO']; ?>">
							</a>
						</div>
						<?php endif; ?>
						<div class="card-body">
							<h5 class="card-title text-center text-primary mb-0">
								<a id="ver-video" href="./video.php?v=<?= $video['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $_SESSION['EMPRESA_USUARIO']; ?>" data-video="<?= $video['NOME_VIDEO']; ?>" data-usuario="<?= $_SESSION['NOME_USUARIO']; ?>">
									<?= $video['NOME_VIDEO']; ?>
								</a>
							</h5>
						</div>
					</div>
				</div>
				<?php endforeach; ?>

			</div><!-- end row -->
			<?php else: ?>
			<div class="alert alert-primary" role="alert">
				Nenhum vídeo cadastrado nesse álbum.
			</div>
			<?php endif; ?>

		</div>
	</section>
	<?php endif; ?>

</main>

<?php require('_footer.php'); ?>