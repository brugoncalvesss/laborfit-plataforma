<?php
require('control.php');
require('_header.php');

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

	<div class="bg-light py-5 mb-5" style="min-height:450px">
		<div class="container text-center">
			<h2 class="h3 font-weight-bold">Projeto 90 dias</h2>
		</div>
	</div>

	<div class="container mb-5 text-center">
		<p class="h4 mb-4">Participe do treinamento especial WOW Life 90 dias</p>
		<p><a href="/programa.php" class="btn btn-dark">Começar</a></p>
	</div>

</main>

<?php require('_footer.php'); ?>