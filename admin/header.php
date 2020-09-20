<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="#">Plataforma</a>

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
	</button>
  
	<ul class="navbar-nav ml-auto d-none d-lg-flex">
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-exchange-alt mr-1"></i> <?= $_SESSION['NOME_EMPRESA'] ?>
			</a>
			<?php if ($_SESSION['SUPER_ADMIN']) : ?>
				<?php
				$PDO = db_connect();

				$sql = "SELECT * FROM EMPRESAS ORDER BY NOME_EMPRESA ASC";
				$request = $PDO->prepare($sql);
				$request->execute();
				$arResult = $request->fetchAll(PDO::FETCH_ASSOC);
				?>
				<?php if (!empty($arResult)) : ?>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
					<?php foreach ($arResult as $empresa) : ?>
					<a class="dropdown-item" href="/admin/empresas/alterarEmpresa.php?id=<?= $empresa['ID_EMPRESA']; ?>">
						<?= $empresa['NOME_EMPRESA']; ?>
					</a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			<?php endif; ?>
		</li>
		<li class="nav-item">
			<span class="nav-link">
			<?= $_SESSION['EMAIL'] ?>
			</span>
		</li>
		<li class="nav-item active">
			<a class="nav-link" href="/admin/login/logout.php">
				<i class="fas fa-sign-out-alt"></i> Sair
			</a>
		</li>
	</ul>
</nav>

<div class="container-fluid">
	<div class="row">
	