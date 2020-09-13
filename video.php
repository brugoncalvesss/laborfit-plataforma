<?php
require('control.php');
require('_header.php');

if ($_GET['v']) {
	$video = getVideoId($_GET['v']);
} else {
	header("location: /?status=500");
	exit();
}

if (!empty($video)) {
	$arRelacionados = getVideosRelacionados($video['ID_CATEGORIA']);
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
				<li class="nav-item">
					<a href="./aulas.php" class="nav-link">Aulas</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link text-decoration-none dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
						<i class="far fa-user-circle text-primary"></i>
						<span id="usuario" class="sr-only">
							<?= $_SESSION['usuario']; ?>
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="/logout.php">Sair</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>

	<header class="video-header bg-primary text-light text-center py-3">
		<div class="mb-3">
			<a href="./album.php?q=<?= $video['ID_CATEGORIA']; ?>" class="btn btn-link text-white rounded-pill text-decoration-none border-bottom pb-0">
				<?= $video['NOME_CATEGORIA']; ?>
			</a>
		</div>
		<h2 class="h4 font-weight-bold"><?= $video['NOME_VIDEO']; ?></h2>
	</header>

	<section class="video-content">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-10 offset-md-1">
					<div class="card border-0">
						<div class="embed-responsive embed-responsive-16by9 video-border">
							<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/<?= $video['LINK_VIDEO']; ?>?title=0&byline=0&portrait=0&badge=0&showinfo=0&modestbranding=0" frameborder="0"></iframe>
						</div>
						<?php if (!empty($video['DESC_VIDEO'])) : ?>
						<div class="card-body text-center">
							<h5 class="card-title text-primary font-weight-bold">Descrição</h5>
							<p><?= $video['DESC_VIDEO']; ?></p>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php if (!empty($arRelacionados)) : ?>
	<section class="video-related bg-light pt-4 pb-5">
		<div class="container">

			<div class="mb-4 text-center">
				<h2 class="h3 font-weight-bold text-primary">Vídeos Relacionados</h2>
			</div>

			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
				<?php foreach ($arRelacionados as $relacionado) : ?>
				<div class="col">
					<div class="card card-video mb-3">
						<?php if ($relacionado['THUMB_VIDEO']) : ?>
						<div class="card-cover">
							<a id="ver-video" href="./video.php?v=<?= $relacionado['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $relacionado['NOME_EMPRESA']; ?>" data-video="<?= $relacionado['NOME_VIDEO']; ?>" data-usuario="<?= $_SESSION['usuario']; ?>">
								<img src="./uploads/<?= $relacionado['THUMB_VIDEO']; ?>" class="img-fluid img-cover" alt="<?= $relacionado['NOME_VIDEO']; ?>">
							</a>
						</div>
						<?php endif; ?>
						<div class="card-body">
							<h5 class="card-title text-center text-primary mb-0">
							<a id="ver-video" href="./video.php?v=<?= $relacionado['LINK_VIDEO']; ?>" class="text-decoration-none" data-empresa="<?= $relacionado['NOME_EMPRESA']; ?>" data-video="<?= $relacionado['NOME_VIDEO']; ?>" data-usuario="<?= $_SESSION['usuario']; ?>">
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

</main>

<?php
$_footer = '_footer.php';
include($_footer);
?>