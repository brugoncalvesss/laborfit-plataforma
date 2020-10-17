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