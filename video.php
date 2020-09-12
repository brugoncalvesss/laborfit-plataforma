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


	<div class="container py-4 mb-5">
		<div class="row">
			<div class="col-12 col-md-8 offset-md-2">
				<div class="card mb-3">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/<?= $video['LINK_VIDEO']; ?>?title=0&byline=0&portrait=0&badge=0&showinfo=0&modestbranding=0" frameborder="0"></iframe>
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