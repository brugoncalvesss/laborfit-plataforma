<?php
require('control.php');
require('_header.php');

if (!$_SESSION['EMPRESA_USUARIO']) {
	die("Erro: Não conseguimos carregar seus dados.");
}

$arBanner = getBannerFrontPage();
$arAlbums = getAlbums();

$arTemas = getTemas();

?>

<main>
	<nav class="navbar navbar-expand-md navbar-light bg-white">
		<div class="container">
			<a href="/" class="navbar-brand">
				<img src="./img/logo.png" alt="Logo WoW Life" height="50">
			</a>
			<ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item font-weight-600">
                    <a href="/receitas.php" class="nav-link">Receitas</a>
                </li>
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
		<ol class="carousel-indicators">
			<?php foreach ($arBanner as $key => $banner) : ?>
			<?php $active = ($key < 1) ? 'active' : ''; ?>
			<li data-target="#carouselExampleIndicators" data-slide-to="<?= $key ?>" class="<?= $active ?>"></li>
			<?php endforeach; ?>
		</ol>
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
		<a class="carousel-control-prev" href="#carouselBanners" role="button" data-slide="prev">
			<i class="icon arrow-left"></i>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselBanners" role="button" data-slide="next">
			<i class="icon arrow-right"></i>
			<span class="sr-only">Next</span>
		</a>
		</div>
	<div>
	<?php endif; ?>

	<section class="tags py-5 bg-wave text-center">
		<div class="container">

			<button class="btn btn-primary btn-lg btn-alt" type="button" data-toggle="modal" data-target="#modalTemas">
			O que você precisa hoje para um dia WoW? <i class="fas fa-chevron-down pl-1"></i>
			</button>

		</div>
	</section>

	<?php $arDestaques = getVideosDestaque(); ?>
	<?php if (!empty($arDestaques)) : ?>	
	<section id="destaques" class="destaques my-4">
		<div class="d-block mb-3 text-center">
			<h4 class="h6 title-line">Destaques WOW do Dia</h4>
		</div>
		<div class="container">
			<div class="owl-carousel">
				<?php foreach ($arDestaques as $destaque) : ?>
				<div class="col-item">
					<div class="card card-hover">
						<div class="card-header bg-blue text-light text-center border-0">
							<h5 class="font-weight-600 mb-0"><?= $destaque['NOME_DESTAQUE']; ?></h5>
						</div>
						<div class="card-cover">
							<a href="./video.php?v=<?= $destaque['LINK_VIDEO']; ?>" class="text-decoration-none">
								<img src="./uploads/<?= $destaque['THUMB_VIDEO']; ?>" class="img-cover" alt="<?= $destaque['NOME_VIDEO']; ?>">
							</a>
						</div>
						<div class="card-body text-center d-none">
							<h5 class="center-title font-weight-600 text-primary mb-0">
								<a href="./video.php?v=<?= $destaque['LINK_VIDEO']; ?>" class="text-decoration-none">
									<?= $destaque['INTRO_VIDEO']; ?>
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
	<section id="albums" class="albums py-4">
		<div class="container">

			<div class="d-block mb-3 text-center">
				<h4 class="h6 title-line">Escolha uma categoria</h4>
			</div>

			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
				<?php foreach ($arAlbums as $album) : ?>
					<?php if ($album['IMG_CATEGORIA']) : ?>
					<div class="col">
						<div class="card mb-3 border-0 bg-dark bg-cover card-album" style="background-image:url(./uploads/<?= $album['IMG_CATEGORIA']; ?>)">
							<a href="./categoria.php?q=<?= $album['ID_CATEGORIA']; ?>" class="card-body text-decoration-none">
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

<div class="modal modal-mobile-fullscreen" id="modalTemas" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">

				<div class="d-block">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<nav class="nav flex-column">
				<?php foreach ($arTemas as $tema) : ?>
					<a href="/tag.php?q=<?= $tema['ID_TEMA']; ?>" class="nav-link">
						<?= $tema['NOME_TEMA'] ?>
					</a>
				<?php endforeach; ?>
				</nav>

			</div>
		</div>
	</div>
</div>

<?php require('_footer.php'); ?>