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

				<div class="row">
					<div class="col-12 col-md-10 offset-md-1">
					<p><?= $receita['DESCRICAO_RECEITA']; ?></p>
					</div>
				</div>

			</section>

		</div><!-- container -->

	</div>

</main>

<?php require_once '_footer.php'; ?>