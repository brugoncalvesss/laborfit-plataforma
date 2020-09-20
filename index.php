<?php
require('control.php');
require('_header.php');

if (!$_SESSION['EMPRESA_USUARIO']) {
	die("Erro: Não conseguimos carregar seus dados.");
}

$arBanner = getBannerFrontPage();
$arDestaques = getAlbumDestaque();
$arAlbums = getAlbums();

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
						<span id="usuario" class="sr-only"><?= $_SESSION['NOME_USUARIO']; ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="/logout.php">Sair</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>

	<?php if (!empty($arBanner)) : ?>
	<div id="carouselBanners" class="carousel slide section-banner" data-ride="carousel">
		<div class="carousel-inner">
		<?php foreach ($arBanner as $key => $banner) : ?>
			<?php $active = ($key < 1) ? 'active' : ''; ?>
			<?php if (file_exists('./uploads/'.$banner['IMG_BANNER'])) : ?>
				<div class="carousel-item <?= $active ?>">
					<a href="<?= $banner['LINK_BANNER'] ?>">
					<img src="/uploads/<?= $banner['IMG_BANNER'] ?>" class="img-banner d-block w-100" alt="<?= $banner['IMG_BANNER'] ?>">
					</a>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
		</div>
		<a class="carousel-control-prev" href="#carouselBanners" role="button" data-slide="prev">
			<i class="fas fa-chevron-left"></i>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselBanners" role="button" data-slide="next">
			<i class="fas fa-chevron-right"></i>
			<span class="sr-only">Next</span>
		</a>
	<div>
	<?php endif; ?>

	<?php if (!empty($arDestaques)) : ?>
	<section id="destaques" class="destaques mt-5 mb-4">
		<div class="container">
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
				<?php foreach ($arDestaques as $destaque) : ?>
				<div class="col">
					<div class="card card-hover mb-3">
						<?php if ($destaque['DESC_CATEGORIA']) : ?>
						<div class="card-header bg-white text-center">
							<h5 class="card-title text-primary mb-0">
							<?= $destaque['DESC_CATEGORIA']; ?>
							</h5>
						</div>
						<?php endif; ?>
						<?php if ($destaque['IMG_CATEGORIA']) : ?>
						<div class="card-cover">
							<a href="./album.php?q=<?= $destaque['ID_CATEGORIA']; ?>" class="text-decoration-none">
								<img src="./uploads/<?= $destaque['IMG_CATEGORIA']; ?>" class="img-cover" alt="<?= $destaque['NOME_CATEGORIA']; ?>">
							</a>
						</div>
						<?php endif; ?>
						<div class="card-body text-center">
							<h5 class="card-title text-primary mb-0">
								<a href="./album.php?q=<?= $destaque['ID_CATEGORIA']; ?>" class="text-decoration-none">
									<?= $destaque['NOME_CATEGORIA']; ?>
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

	<?php if (!empty($arAlbums)) : ?>
	<section id="albums" class="albums py-4 bg-wave">
		<div class="container">

			<div class="mb-5 text-center">
				<div class="d-block mb-2">
					<h4 class="h6 title-line">Tenha um dia WOW!</h4>
				</div>
				<div class="d-inline-block rounded-pill bg-primary text-light font-weight-800 px-4 py-3">
					O que você precisa hoje? <i class="fas fa-chevron-down pl-1"></i>
				</div>
			</div>

			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
				<?php foreach ($arAlbums as $album) : ?>
					<?php if ($album['IMG_CATEGORIA']) : ?>
					<div class="col">
						<div class="card mb-3 bg-dark bg-cover card-album" style="background-image:url(./uploads/<?= $album['IMG_CATEGORIA']; ?>)">
							<a href="./album.php?q=<?= $album['ID_CATEGORIA']; ?>" class="card-body text-decoration-none">
								<h5 class="card-title text-center mb-0 text-light">
									<?= $album['NOME_CATEGORIA']; ?>
								</h5>
							</a>
						</div>
					</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</main>

<?php require('_footer.php'); ?>