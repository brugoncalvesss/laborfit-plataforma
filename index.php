<?php
$_header = '_header.php';
include($_header);

if (!$_SESSION) {
	header("location: /login.php");
	exit();
}

$page = [];

if ($_SESSION['empresa']) {
	$page = getPageCompany($_SESSION['empresa']);
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

	<section class="banner bg-dark text-light">
		<div class="text-center py-5 mb-4">
			BANNER
		</div>
	</section>

	<section class="filter">
		<div class="container">
			<div class="row flex-wrap">
				<div class="col-sm-8">
					<div class="bg-light w-100 p-4">

						<header class="text-center mb-3">
							<h4 class="font-weight-bold text-uppercase">
								ATIVIDADES PARA FAZER ONDE ESTIVER
							</h4>
							<h5 class="text-muted font-weight-bold">
								Escolha uma das categorias abaixo e VEM COM A GENTE!
							</h5>
						</header>

						<select name="filtro" class="form-control mx-auto" style="max-width:560px">
							<option value="0">Filtrar</option>
						</select>

					</div>
				</div>
				<div class="col-sm-4">
					<div class="bg-light d-flex align-items-center p-4 h-100">
						<div class="row align-items-center">
							<div class="col col-auto">
								<img src="/img/img-teste.png" width="80">
							</div>
							<div class="col">
								<div class="text-center">
									<h4 class="h6 font-weight-bold">PESQUISA DE IDADE DA QUALIDADE DE VIDA</h4>
									<p class="small text-muted">Faça o nosso teste e descubra!</p>
									<div>
										<a target="_blank" href="https://pesquisalaborfit.com.br/login.html" class="btn btn-sm btn-orange font-weight-bold">
											INICIAR TESTE
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="container py-5 mb-5">
		<?php if (!empty($page)) : ?>
		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
			<?php foreach ($page as $video) : ?>
			<div class="col">
				<div class="card card-video mb-3">
					<?php if ($video['THUMB_VIDEO']) : ?>
					<a
						id="assistir-video"
						href="./video.php?v=<?= $video['ID_VIDEO']; ?>"
						class="text-decoration-none"
						data-empresa="<?= $video['NOME_EMPRESA']; ?>"
						data-video="<?= $video['NOME_VIDEO']; ?>">
						<img src="./uploads/<?= $video['THUMB_VIDEO']; ?>" class="card-img-top" alt="<?= $video['NOME_VIDEO']; ?>">
					</a>
					<?php endif; ?>
					<div class="card-body">
						<h5 class="card-title text-center text-primary mb-0">
							<a
								id="assistir-video"
								href="./video.php?v=<?= $video['ID_VIDEO']; ?>"
								class="text-decoration-none"
								data-empresa="<?= $video['NOME_EMPRESA']; ?>"
								data-video="<?= $video['NOME_VIDEO']; ?>">
								<?= $video['NOME_VIDEO']; ?>
							</a>
						</h5>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php else: ?>
		<div class="alert alert-warning">Nenhum vídeo adicionado</div>
		<?php endif; ?>
	</div>
</main>

<?php
$_footer = '_footer.php';
include($_footer);
?>