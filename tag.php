<?php
require('control.php');
require('_header.php');

$idTema = isset($_GET['q']) ? $_GET['q'] : null;

if (!$idTema) {
	die("Erro: Tema não encontrado.");
}

$tema = getTema($idTema);
$arVideos = getVideoPorIdTema($idTema);
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

	<header class="tag-header bg-wave-primary text-light text-center py-3">
		<div class="container">

			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-light bg-transparent">
					<li class="breadcrumb-item"><a href="/">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?= $tema['NOME_TEMA']; ?></li>
				</ol>
			</nav>

			<h1 class="h2 text-light font-weight-600 mt-2">
				<?= $tema['NOME_TEMA']; ?>
			</h1>
			<p><?= $tema['DESCRICAO_TEMA']; ?></p>
		</div>
	</header>

    <section class="videos py-3">
        <div class="container">

            <?php if (!empty($arVideos)) : ?>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                <?php foreach ($arVideos as $video) : ?>
                <div class="col mb-3">
					<div class="card card-hover h-100">
						<div class="card-cover">
							<a href="./video.php?v=<?= $video['LINK_VIDEO']; ?>&ref=<?= $idTema; ?>" class="text-decoration-none">
								<img src="./uploads/<?= $video['THUMB_VIDEO']; ?>" class="img-cover" alt="<?= $video['NOME_VIDEO']; ?>">
							</a>
						</div>
					</div>
				</div>
                <?php endforeach; ?>
                </div>
            <?php else : ?>
            <div class="alert alert-primary" role="alert">
            	Não encontramos nenhum vídeo com esse tema.
            </div>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php require('_footer.php'); ?>