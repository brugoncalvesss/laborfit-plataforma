<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php';

$search = isset($_GET['q']) ? $_GET['q'] : null;
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
            <h1 class="h3 my-0">Vídeos</h1>
		</div>
        <div class="col text-sm-right">
            <a class="btn btn-primary btn-sm" href="/admin/paginas/novo.php">Novo</a>
        </div>
	</header>
    
    <div class="mb-5">
		<?php
		$PDO = db_connect();

		$sql = "SELECT * FROM VIDEOS ORDER BY VIDEOS.NOME_VIDEO ASC";
		$stmt = $PDO->prepare($sql);

		try{
			$stmt->execute();
			$arVideos = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception("Erro ao carregar banners: " . $e->getMessage());
		}
		?>

		<?php if (count($arVideos) > 0) : ?>
		<div class="table-responsive datatable-custom">
			<table id="basicDatatable" class="table table-borderless card-table">
				<thead class="thead-light">
					<tr>
						<th>Nome</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($arVideos as $video) : ?>
					<tr>
						<td><?= $video['NOME_VIDEO']; ?></td>
						<td class="text-right">
							<a class="btn-link mx-2" href="/admin/paginas/editar.php?id=<?= $video['ID_VIDEO']; ?>">
								<i class="far fa-edit"></i>
							</a>
							<a class="btn-link mx-2" href="/admin/paginas/deletarVideo.php?id=<?= $video['ID_VIDEO'] ?>">
								<i class="far fa-trash-alt"></i>
							</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
		   </table>
		</div>
		<?php endif; ?>

    </div>
	
</main>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>