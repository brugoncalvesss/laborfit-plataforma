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
	<nav class="nav py-3 bg-dark text-light">
		<div class="container">
			<div class="d-flex justify-content-between">
				<div><code>Página inicial</code></div>
				<div><a href="/logout.php">logout</a></div>
			</div>
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

						<select name="filtro" class="form-control">
							<option value="0">Filtrar</option>
						</select>

					</div>
				</div>
				<div class="col-sm-4">
					<div class="bg-light w-100 p-4 h-100">

					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="container py-5 mb-5">
		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
			<?php $a = 1; while ($a <= 12) : ?>
			<div class="col">
				<div class="card card-video mb-3">
					<a href="./video.php?watch=" class="text-decoration-none">
						<img src="..." class="card-img-top" alt="...">
					</a>
					<div class="card-body">
						<h5 class="card-title text-center text-primary mb-0">
							<a href="./video.php?watch=" class="text-decoration-none">
								Card title
							</a>
						</h5>
					</div>
				</div>
			</div>
			<?php $a++; endwhile; ?>
		</div>
	</div>
</main>

<?php
$_footer = '_footer.php';
include($_footer);
?>