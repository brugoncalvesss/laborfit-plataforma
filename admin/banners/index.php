<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Banners</h1>
		</div>
        <div class="col text-sm-right">
            <a class="btn btn-primary btn-sm" href="/admin/banners/novo.php">Novo</a>
        </div>
	</header>
    
    <div>
		<?php
		$PDO = db_connect();
		$sql = "SELECT * FROM
                    BANNERS
                ORDER BY
                    ID_BANNER
                DESC";
		$stmt = $PDO->prepare($sql);

		try{
			$stmt->execute();
			$arBanners = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception("Erro ao carregar banners: " . $e->getMessage());
		}
		?>

		<?php if (count($arBanners) > 0) : ?>
			<?php foreach ($arBanners as $banner) : ?>
			<div class="row align-items-center no-gutters border-bottom mb-2 pb-2">
				<div class="col">
					<img src="/uploads/<?= $banner['IMG_BANNER'] ?>" class="img-fluid" width="150">
				</div>
				<div class="col col-auto">
					<a class="btn btn-link" href="/admin/banners/editar.php?id=<?= $banner['ID_BANNER'] ?>">
						<i class="far fa-edit"></i>
					</a>
					<a href="/admin/banners/deletarBanner.php?id=<?= $banner['ID_BANNER']; ?>" class="btn btn-link">
						<i class="far fa-trash-alt"></i>
					</a>
				</div>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>
    </div>
	
</main>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>