<?php
require('control.php');
require('_header.php');

$idAlbum = $_GET['q'] ?: null;

if (!$idAlbum) {
	die("Erro: Não foi informado o álbum.");
}

$arVideos = getAlbum($idAlbum);
?>

<main>
<nav class="navbar navbar-expand-md navbar-light bg-white">
		<div class="container">
			<a href="/" class="navbar-brand">
				<img src="./img/logo.png" alt="Logo WoW Life" height="60">
			</a>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="/logout.php">Sair</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>
    
    <?php if (!empty($arVideos)) : ?>
    <section id="videos" class="videos py-5">
        <div class="container">
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
				
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php require('_footer.php'); ?>