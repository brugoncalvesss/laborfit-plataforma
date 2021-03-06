<?php
require('control.php');
require('_header.php');

$idCategoria = isset($_GET['q']) ? $_GET['q'] : null;

if (!$idCategoria) {
	die("Erro: Não foi informado o álbum.");
}

$arCategoriaDestaque = getVideoDestaqueCategoria($idCategoria);

if ($arCategoriaDestaque) {
	$randVideo = date('w');

	if (count($arCategoriaDestaque) > 30) {
		$randVideo = date('d');
	}
	
	$categoriaDestaque = $arCategoriaDestaque[$randVideo] ?
		$arCategoriaDestaque[$randVideo] :
		$arCategoriaDestaque[0];
}

$arVideos = getVideoPorIdCategoria($idCategoria);

$categoria = getCategoria($idCategoria);

$arReceitas = getReceitaPorCategoria($idCategoria);
?>

<main>
	<nav class="navbar navbar-expand-md navbar-light bg-white">
		<div class="container">

			<a href="/" class="navbar-brand">
				<img src="./img/logo.png" alt="Logo WoW Life" height="50">
			</a>

			<div class="dropdown">
				<a class="dropdown-toggle" href="#" data-toggle="dropdown">
					<img src="./img/user.png" alt="Perfil">
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" href="/logout.php">Sair</a>
				</div>
			</div>
		  
		</div>
	</nav>

	<header class="bg-wave-primary bg-header-video">
	</header>

	<div class="page push-content">

		<div class="container">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-light bg-transparent">
					<li class="breadcrumb-item"><a href="/">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?= $categoria['NOME_CATEGORIA']; ?></li>
				</ol>
			</nav>

			<section class="text-center text-light">
				<h1 class="font-weight-600 mt-2">
					<?= $categoria['NOME_CATEGORIA']; ?>
				</h1>
				<h2 class="h4 d-inline-block text-truncate" style="max-width: 100%">
					<?= $categoria['DESC_CATEGORIA']; ?>
				</h2>
			</section>

			<section class="video-content">
				<div class="row">
					<div class="col-12 col-md-10 offset-md-1">
						<div class="card border-0">
							<?php if (!empty($categoriaDestaque)) : ?>
							<div class="video-categoria video-border bg-dark">
								<a id="ver-video" href="./video.php?v=<?= $categoriaDestaque['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $_COOKIE["USUARIO_EMPRESA"]; ?>" data-video="<?= $categoriaDestaque['NOME_VIDEO']; ?>" data-usuario="<?= $_COOKIE["USUARIO_NOME"]; ?>">
									<img src="./uploads/<?= $categoriaDestaque['THUMB_VIDEO']; ?>" class="img-fluid cover">
								</a>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>

			<section id="videos" class="videos py-5">

				<div class="mb-5 text-center">
					<div class="d-block mb-2">
						<h4 class="h6 title-line">Lista de vídeos WOW!</h4>
					</div>
				</div>

				<?php if (!empty($arVideos)) : ?>
				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">

					<?php foreach ($arVideos as $video) : ?>
					<div class="col mb-30">
						<div class="card card-video h-100">
							<?php if ($video['THUMB_VIDEO']) : ?>
							<div class="card-cover">
								<a id="ver-video" href="./video.php?v=<?= $video['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $_COOKIE["USUARIO_EMPRESA"]; ?>" data-video="<?= $video['NOME_VIDEO']; ?>" data-usuario="<?= $_COOKIE["USUARIO_NOME"]; ?>">
									<img src="./uploads/<?= $video['THUMB_VIDEO']; ?>" class="img-cover" alt="<?= $video['NOME_VIDEO']; ?>">
								</a>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php endforeach; ?>

					<?php if (!empty($arReceitas)) : ?>
					<?php foreach ($arReceitas as $receita) : ?>
					<div class="col mb-30">
						<div class="card card-video h-100">
							<?php if ($receita['IMG_RECEITA']) : ?>
							<div class="card-cover">
								<a href="./receita.php?q=<?= $receita['ID_RECEITA']; ?>" class="text-decoration-none">
									<img src="./uploads/<?= $receita['IMG_RECEITA']; ?>" class="img-cover" alt="<?= $receita['NOME_RECEITA']; ?>">
								</a>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php endforeach; ?>
					<?php endif; ?>

				</div><!-- end row -->
				<?php else: ?>
				<div class="alert alert-primary" role="alert">
					Nenhum vídeo cadastrado nessa categoria.
				</div>
				<?php endif; ?>

			</section>
			
		</div>

	</div>

</main>

<?php require('_footer.php'); ?>