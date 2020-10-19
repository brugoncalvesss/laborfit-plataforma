<?php
require_once 'control.php';
require_once '_header.php';

$idVideo = $_GET['v'] ?: null;

if (!$idVideo) {
	die("Erro: Não foi possível enontrar o vídeo.");
}

$video = getVideo($idVideo);
$videosRelacionados = getVideosRelacionados($idVideo, $video['ALBUM_VIDEO']);
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
			<ol class="breadcrumb breadcrumb-light bg-transparent mb-0">
				<li class="breadcrumb-item"><a href="/">Home</a></li>
				<li class="breadcrumb-item"><a href="./categoria.php?q=<?= $video['ALBUM_VIDEO']; ?>"><?= $video['NOME_CATEGORIA']; ?></a></li>
			</ol>
			</nav>

			<section class="text-center text-light mb-3">
				<div class="mb-3">
					<a href="./categoria.php?q=<?= $video['ALBUM_VIDEO']; ?>" class="btn btn-link btn-categoria text-white rounded-pill">
						<?= $video['NOME_CATEGORIA']; ?>
					</a>
				</div>
				<h2 class="h4 font-weight-600"><?= $video['NOME_VIDEO']; ?></h2>
			</section>

			<section class="video-content mb-5">
				<div class="row">
					<div class="col-12 col-md-10 offset-md-1">
						<div class="card border-0">
							<div class="embed-responsive embed-responsive-16by9 video-border">
								<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/<?= $video['LINK_VIDEO']; ?>?title=0&byline=0&portrait=0&badge=0&showinfo=0&modestbranding=0" frameborder="0"></iframe>
							</div>
							<?php if (!empty($video['DESC_VIDEO'])) : ?>
							<div class="card-body text-center mb-3">
								<h5 class="card-title text-primary font-weight-bold">Descrição</h5>
								<p class="font-weight-600"><?= $video['DESC_VIDEO']; ?></p>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>

		</div><!-- container -->

		<?php if (!empty($videosRelacionados)) : ?>
		<section class="video-related bg-wave py-4">
			<div class="container">

				<div class="mb-4 text-center">
					<h2 class="h3 font-weight-bold text-primary">Vídeos Relacionados</h2>
				</div>

				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
					<?php foreach ($videosRelacionados as $relacionado) : ?>
					<div class="col">
						<div class="card card-hover mb-3">
							<?php if ($relacionado['THUMB_VIDEO']) : ?>
							<div class="card-cover">
								<a id="ver-video" href="./video.php?v=<?= $relacionado['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $_SESSION['NOME_EMPRESA']; ?>" data-video="<?= $relacionado['NOME_VIDEO']; ?>" data-usuario="<?= $_SESSION['NOME_USUARIO']; ?>">
									<img src="./uploads/<?= $relacionado['THUMB_VIDEO']; ?>" class="img-fluid img-cover" alt="<?= $relacionado['NOME_VIDEO']; ?>">
								</a>
							</div>
							<?php endif; ?>
							<div class="card-body">
								<h5 class="card-title text-center text-primary mb-0">
								<a id="ver-video" href="./video.php?v=<?= $relacionado['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $_SESSION['NOME_EMPRESA']; ?>" data-video="<?= $relacionado['NOME_VIDEO']; ?>" data-usuario="<?= $_SESSION['NOME_USUARIO']; ?>">
										<?= $relacionado['NOME_VIDEO']; ?>
									</a>
								</h5>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php endif; ?>

	</div>

</main>

<?php require_once '_footer.php'; ?>