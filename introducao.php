<?php
require_once 'control.php';
require_once '_header.php';

$idPrograma = $_GET['programa'] ?: 1;
$arPrograma = getPrograma($idPrograma);
?>

<main>
	<nav class="navbar navbar-expand-md navbar-light bg-white">
		<div class="container">

			<a href="/" class="navbar-brand">
				<img src="./img/logo.png" alt="Logo WoW Life" height="50">
			</a>

			<div class="dropdown">
				<a class="dropdown-toggle" href="#" data-toggle="dropdown">
					<img src="./img/user.png" alt="Perfil">
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" href="/logout.php">Sair</a>
				</div>
			</div>
		  
		</div>
	</nav>

	<div class="bg-light py-4 mb-5">
		<div class="container text-center">
			<h2 class="h3 font-weight-bold mb-4"><?= $arPrograma[0]['NOME_PROGRAMA'] ?></h2>

			<div class="offset-md-2 col-md-8">
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/<?= $arPrograma[0]['VIMEO_PROGRAMA'] ?>?title=0&byline=0&portrait=0&badge=0&showinfo=0&modestbranding=0" frameborder="0"></iframe>
				</div>
			</div>

		</div>
	</div>

	<div class="container mb-5 text-center">
		<p class="h4 mb-4">Participe do treinamento especial WOW Life 90 dias</p>
		<p><a href="/programa.php?programa=<?= $arPrograma[0]['ID_PROGRAMA'] ?>" class="btn btn-dark">Começar</a></p>
	</div>

</main>

<?php require('_footer.php'); ?>