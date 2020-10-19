<?php
require_once 'control.php';
require_once '_header.php';

$idReceita = isset($_GET['q']) ? $_GET['q'] : null;

if (!$idReceita) {
	die("Erro: Não foi possível enontrar a receita.");
}

$receita = getReceita($idReceita);
?>

<main>
	<nav class="navbar navbar-expand-md navbar-light bg-white">
		<div class="container">

			<a href="/" class="navbar-brand">
				<img src="./img/logo.png" alt="Logo WoW Life" height="50">
			</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPrimary" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarPrimary">

				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
							<img src="./img/user.png" alt="Perfil">
							<span id="usuario" class="sr-only"><?= $_SESSION['NOME_USUARIO']; ?></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="/logout.php">Sair</a>
						</div>
					</li>
				</ul>

			</div>
		  
		</div>
	</nav>

	<header class="bg-wave-primary bg-header-video">
	</header>

	<div class="page push-content">

		<div class="container">

			<nav aria-label="breadcrumb">
			<ol class="breadcrumb breadcrumb-light bg-transparent mb-0">
				<li class="breadcrumb-item"><a href="/">Home</a></li>
				<li class="breadcrumb-item"><a href="./receitas.php">Receitas</a></li>
			</ol>
			</nav>

			<section class="text-center text-light mb-3">
				<h2 class="h4 font-weight-600"><?= $receita['NOME_RECEITA']; ?></h2>
			</section>

			<section class="video-content mb-5">
                <div class="row">
					<div class="col-12 col-md-10 offset-md-1">
						<div class="card border-0">
							<?php if ($receita['IMG_RECEITA']) : ?>
							<div class="video-categoria video-border bg-light text-center">
                                <img src="./uploads/<?= $receita['IMG_RECEITA']; ?>" class="img-fluid cover">
							</div>
							<?php endif; ?>
						</div>
					</div>
                </div>
                
                <p><?= $receita['DESCRICAO_RECEITA']; ?></p>

			</section>

		</div><!-- container -->

	</div>

</main>

<?php require_once '_footer.php'; ?>