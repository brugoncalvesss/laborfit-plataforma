<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
            <h1 class="h3 my-0">Temas</h1>
		</div>
        <div class="col text-sm-right">
            <a class="btn btn-primary btn-sm" href="/admin/temas/novo.php">Novo</a>
        </div>
	</header>
    
    <div>
		<?php
		$PDO = db_connect();
		$sql = "SELECT * FROM
                    TEMAS
                ORDER BY
                    TEMAS.NOME_TEMA
                ASC";
		$stmt = $PDO->prepare($sql);

		try{
			$stmt->execute();
			$arResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception("Erro ao carregar os temas: " . $e->getMessage());
		}
		?>

		<?php if (count($arResult) > 0) : ?>
			<?php foreach ($arResult as $tema) : ?>
			<div class="row align-items-center no-gutters border-bottom mb-2 pb-2">
				<div class="col">
					<?= $tema['NOME_TEMA']; ?>
				</div>
				<div class="col col-auto">
					<a class="btn btn-link" href="/admin/temas/editar.php?id=<?= $tema['ID_TEMA']; ?>">
						<i class="far fa-edit"></i>
					</a>
					<a class="btn btn-link" href="/admin/temas/delete.php?id=<?= $tema['ID_TEMA']; ?>">
						<i class="far fa-trash-alt"></i>
					</a>
				</div>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>
    </div>
	
</main>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>