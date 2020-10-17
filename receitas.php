<?php
require_once 'control.php';
require_once '_header.php';

$arReceitas = getReceitas();
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
					<li class="nav-item">
						<a class="nav-link" href="/receitas.php">Receitas</a>
					</li>
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

	<header class="tag-header bg-wave-primary text-light text-center py-3">
		<div class="container">

			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-light bg-transparent">
					<li class="breadcrumb-item"><a href="/">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">Receitas</li>
				</ol>
			</nav>

			<h1 class="h2 text-light font-weight-600 mt-2">
				Receitas
			</h1>
		</div>
	</header>

    <section class="videos py-3">
        <div class="container">

            <?php if (!empty($arReceitas)) : ?>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                <?php foreach ($arReceitas as $receita) : ?>
                <div class="col mb-3">
					<div class="card card-hover h-100">
						<div class="card-cover">
							<a href="./receita.php?q=<?= $receita['ID_RECEITA']; ?>" class="text-decoration-none">
								<img src="./uploads/<?= $receita['IMG_RECEITA']; ?>" class="img-cover" alt="<?= $receita['NOME_RECEITA']; ?>">
							</a>
						</div>
						<div class="card-body text-center">
							<h5 class="card-title text-primary mb-0">
                                <a href="./receita.php?q=<?= $receita['ID_RECEITA']; ?>" class="text-decoration-none">
									<?= $receita['NOME_RECEITA']; ?>
								</a>
							</h5>
						</div>
					</div>
				</div>
                <?php endforeach; ?>
                </div>
            <?php else : ?>
            <div class="alert alert-primary" role="alert">
            	Nenhuma receita cadastrada.
            </div>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php require_once '_footer.php'; ?>