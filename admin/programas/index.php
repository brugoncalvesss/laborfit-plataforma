<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'; ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Programas</h1>
		</div>
        <div class="col text-sm-right">
            <a class="btn btn-primary btn-sm" href="/admin/programas/novo.php">Novo</a>
        </div>
	</header>
    
    <div>
		<?php
		$PDO = db_connect();
		$sql = "SELECT * FROM
                    PROGRAMAS
                ORDER BY
                    ID_PROGRAMA
                DESC";
		$stmt = $PDO->prepare($sql);

		try{
			$stmt->execute();
			$arProgramas = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception("Erro ao carregar programas: " . $e->getMessage());
		}
		?>

		<?php if (count($arProgramas) > 0) : ?>
			<?php foreach ($arProgramas as $programa) : ?>
			<div class="row align-items-center no-gutters border-bottom mb-2 pb-2">
				<div class="col">
					<a href="/admin/etapas/?id=<?= $programa['ID_PROGRAMA']; ?>">
					<?= $programa['NOME_PROGRAMA']; ?>
					</a>
				</div>
				<div class="col col-auto">
					<a class="btn-link mx-2" href="/admin/programas/editar.php?id=<?= $programa['ID_PROGRAMA']; ?>">
						<i class="far fa-edit"></i>
					</a>
				</div>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>
    </div>
	
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'; ?>