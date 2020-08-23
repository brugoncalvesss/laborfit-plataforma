<?php
if (!$_SESSION) {
    header("location: /admin/login/?logout=1");
    exit();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="#">Plataforma</a>

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
	</button>
  
	<ul class="navbar-nav ml-auto d-none d-lg-flex">
		<?php if ($_SESSION['nome']) : ?>
		<li class="nav-item">
			<span class="nav-link text-white">
				Olá <?= $_SESSION['nome'] ?>
			</span>
		</li>
		<?php endif; ?>
		<li class="nav-item">
			<a class="nav-link" href="/admin/login/logout.php">
				<i class="fas fa-sign-out-alt"></i> Sair
			</a>
		</li>
	</ul>
</nav>

<div class="container-fluid">
	<div class="row">
	