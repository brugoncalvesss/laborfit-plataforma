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
?>

<main>
	<nav class="navbar navbar-expand-md navbar-light bg-white">
		<div class="container">

			<a href="/" class="navbar-brand">
				<img src="./img/logo.png" alt="Logo WoW Life" height="50">
			</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPrimary" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarPrimary">

				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="/receitas.php">Receitas</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
							<img src="./img/user.png" alt="Perfil">
							<span id="usuario" class="sr-only"><?= $_SESSION['NOME_USUARIO']; ?></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="/logout.php">Sair</a>
						</div>
					</li>
				</ul>

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
								<a id="ver-video" href="./video.php?v=<?= $categoriaDestaque['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $_SESSION['NOME_EMPRESA']; ?>" data-video="<?= $categoriaDestaque['NOME_VIDEO']; ?>" data-usuario="<?= $_SESSION['NOME_USUARIO']; ?>">
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
					<div class="col mb-3">
						<div class="card card-video h-100">
							<?php if ($video['THUMB_VIDEO']) : ?>
							<div class="card-cover">
								<a id="ver-video" href="./video.php?v=<?= $video['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $_SESSION['NOME_EMPRESA']; ?>" data-video="<?= $video['NOME_VIDEO']; ?>" data-usuario="<?= $_SESSION['NOME_USUARIO']; ?>">
									<img src="./uploads/<?= $video['THUMB_VIDEO']; ?>" class="img-cover" alt="<?= $video['NOME_VIDEO']; ?>">
								</a>
							</div>
							<?php endif; ?>
							<div class="card-body">
								<h5 class="card-title text-center text-primary mb-0">
									<a id="ver-video" href="./video.php?v=<?= $video['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $_SESSION['NOME_EMPRESA']; ?>" data-video="<?= $video['NOME_VIDEO']; ?>" data-usuario="<?= $_SESSION['NOME_USUARIO']; ?>">
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
					Nenhum vídeo cadastrado nessa categoria.
				</div>
				<?php endif; ?>

			</section>
			
		</div>

	</div>

</main>

<?php require('_footer.php'); ?>