<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
            <h1 class="h3 my-0">Vídeos</h1>
		</div>
        <div class="col text-sm-right">
            <a class="btn btn-primary btn-sm" href="/admin/paginas/novo.php">Novo</a>
        </div>
	</header>
    
    <div>
		<?php
		$PDO = db_connect();
		$sql = "SELECT * FROM
                    VIDEOS
                WHERE
                    EMPRESA_VIDEO = :EMPRESA_VIDEO
                ORDER BY
                    ID_VIDEO
                DESC";
		$stmt = $PDO->prepare($sql);
		$stmt->bindParam(':EMPRESA_VIDEO', $_SESSION['ID_EMPRESA'], PDO::PARAM_INT);

		try{
			$stmt->execute();
			$arVideos = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception("Erro ao carregar banners: " . $e->getMessage());
		}
		?>

		<?php if (count($arVideos) > 0) : ?>
			<?php foreach ($arVideos as $video) : ?>
			<div class="row align-items-center no-gutters border-bottom mb-2 pb-2">
				<div class="col">
					<?= $video['NOME_VIDEO']; ?>
				</div>
				<div class="col col-auto">
					<a class="btn btn-link" href="/admin/paginas/editar.php?id=<?= $video['ID_VIDEO']; ?>">
						<i class="far fa-edit"></i>
					</a>
					<a class="btn btn-link" href="/admin/paginas/deletarVideo.php?id=<?= $video['ID_VIDEO'] ?>&empresa=<?= $video['EMPRESA_VIDEO'] ?>">
						<i class="far fa-trash-alt"></i>
					</a>
				</div>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>
    </div>
	
</main>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>