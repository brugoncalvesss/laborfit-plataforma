<?php
require('control.php');
require('_header.php');

$page = [];
$idEmpresa = $_SESSION['empresa'] ?: null;

if ($_SESSION['empresa']) {
	$arBanner = getBannerCompany($_SESSION['empresa']);
	$arDestaques = getPageDestaques($idEmpresa);
	$arAlbums = getPageAlbums($idEmpresa);
}
?>

<main>
	<nav class="navbar navbar-expand-md navbar-light bg-white">
		<div class="container">
			<a href="/" class="navbar-brand">WoW Life</a>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a href="/" class="nav-link">Home</a>
				</li>
				<li class="nav-item">
					<a href="./aulas.php" class="nav-link">Aulas</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link text-decoration-none dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
						<i class="far fa-user-circle text-primary"></i>
						<span id="usuario" class="sr-only"><?= $_SESSION['usuario']; ?></span>
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
					<div class="card card-video mb-3">
						<?php if ($destaque['IMG_CATEGORIA']) : ?>
						<div class="card-cover">
							<a href="./album.php?q=<?= $destaque['ID_CATEGORIA']; ?>" class="text-decoration-none">
								<img src="./uploads/<?= $destaque['IMG_CATEGORIA']; ?>" class="img-cover" alt="<?= $destaque['NOME_CATEGORIA']; ?>">
							</a>
						</div>
						<?php endif; ?>
						<div class="card-body">
							<h5 class="card-title text-center text-primary mb-0">
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
	<section id="albums" class="albums py-5 bg-light">
	<div class="container">
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
				<?php foreach ($arAlbums as $album) : ?>
				<div class="col">
					<div class="card card-hover mb-3">
						<?php if ($album['IMG_CATEGORIA']) : ?>
						<div class="card-cover">
							<a href="./album.php?q=<?= $album['ID_CATEGORIA']; ?>" class="text-decoration-none">
								<img src="./uploads/<?= $album['IMG_CATEGORIA']; ?>" class="img-cover" alt="<?= $album['NOME_CATEGORIA']; ?>">
							</a>
						</div>
						<?php endif; ?>
						<div class="card-body">
							<h5 class="card-title text-center text-primary mb-0">
								<a href="./album.php?q=<?= $album['ID_CATEGORIA']; ?>" class="text-decoration-none">
									<?= $album['NOME_CATEGORIA']; ?>
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

<?php require('_footer.php'); ?>