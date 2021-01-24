<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'; ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Etapas</h1>
		</div>
	</header>
    
    <div class="mb-5">
		<?php

        $id = $_GET['id'];

        if (empty($id)) {
            header("location: /admin/programas/?msg=not-found");
            exit;
        }

		$arEtapas = getEtapasDoPrograma($id);
		?>

		<?php if (count($arEtapas) > 0) : ?>
		<div class="table-responsive datatable-custom">
			<table class="table table-hover card-table">
				<thead>
					<tr>
						<th>Dia</th>
						<th class="text-right">Badget</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($arEtapas as $etapa) : ?>
					<tr>
						<td>
							<a href="/admin/etapas/editar.php?idPrograma=<?= $etapa['FK_PROGRAMA']; ?>&idEtapa=<?= $etapa['ID_ETAPA']; ?>">
								<?= $etapa['NOME_ETAPA']; ?>
							</a>
						</td>
						<td class="text-right">
							<?php if ($etapa['FL_PREMIO_ETAPA']) : ?>
							<i class="fas fa-star text-warning"></i>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php endif; ?>

    </div>
	
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'; ?>