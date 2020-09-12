<?php
require('control.php');
require('_header.php');

$videos = [];

$idAlbum = $_GET['q'] ?: null;

if ($idAlbum) {
	$videos = getVideosAlbums($idAlbum);
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
    
    <?php if (!empty($videos)) : ?>
    <section id="videos" class="videos py-5">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                <?php foreach ($videos as $video) : ?>
				<div class="col">
					<div class="card card-video mb-3">
						<?php if ($video['THUMB_VIDEO']) : ?>
						<div class="card-cover">
							<a href="./video.php?v=<?= $video['LINK_VIDEO']; ?>" class="text-decoration-none">
								<img src="./uploads/<?= $video['THUMB_VIDEO']; ?>" class="img-fluid img-cover" alt="<?= $video['NOME_VIDEO']; ?>">
							</a>
						</div>
						<?php endif; ?>
						<div class="card-body">
							<h5 class="card-title text-center text-primary mb-0">
								<a href="./video.php?v=<?= $video['LINK_VIDEO']; ?>" class="text-decoration-none">
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