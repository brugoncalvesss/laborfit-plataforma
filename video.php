<?php
require('control.php');
require('_header.php');

if ($_GET['v']) {
	$video = getVideoId($_GET['v']);
} else {
	header("location: /?status=500");
	exit();
}
?>

<main>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
		<div class="container">
			<a href="/" class="navbar-brand">Plataforma</a>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<div class="nav-link">
						Olá,
						<span id="usuario"><?= $_SESSION['usuario']; ?></span>
					</div>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="/logout.php">
					<i class="fas fa-sign-out-alt"></i>
					</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container py-4 mb-5">
		
		<div class="row">
			<div class="col-12 col-md-8 offset-md-2">

				<div class="card mb-3">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?= $video['LINK_VIDEO']; ?>?rel=0&modestbranding=1" allowfullscreen></iframe>
					</div>
					<div class="card-body">
						<h5 class="card-title text-center text-primary">
							<?= $video['NOME_VIDEO']; ?>
						</h5>
					</div>
				</div>
		
			</div>
		</div>

	</div>
</main>

<?php
$_footer = '_footer.php';
include($_footer);
?>