<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = $_GET['id'] ?: null;

if (empty($id)) {
	echo "ID para alteração não definido.";
	exit;
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Editar</h1>
		</div>
	</header>
	
	<div class="mb-3">
		<?php
		$PDO = db_connect();
		$sql = "SELECT * FROM BANNERS WHERE ID_BANNER = :ID_BANNER";
		$stmt = $PDO->prepare($sql);
		$stmt->bindParam(':ID_BANNER', $id, PDO::PARAM_INT);
		
		try{
			$stmt->execute();
			$banner = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception("Erro ao carregar banner: " . $e->getMessage());
		}
		?>

		<?php if (!empty($banner)) : ?>
		<div class="row mb-3">
			<div class="col-12 col-sm-7">
				
				<form action="/admin/banners/editarBanner.php" enctype="multipart/form-data" method="post" autocomplete="off">

					<input type="hidden" name="id" value="<?= $banner['ID_BANNER'] ?>">

					<div class="form-group">
						<label class="small text-uppercase font-weight-bold">Link</label>
						<input type="url" class="form-control" name="LINK_BANNER" value="<?= $banner['LINK_BANNER'] ?>">
					</div>

					<div class="form-group">
						<input type="hidden" name="imagem" value="<?= $banner['IMG_BANNER'] ?>">
						<label class="small text-uppercase font-weight-bold">Capa</label>
						<div class="input-group">
							<div class="custom-file" lang="pt-br">
								<input type="file" class="custom-file-input" name="arquivo" id="inputGroupFile">
								<label class="custom-file-label" for="inputGroupFile">
								<?= $banner['IMG_BANNER'] ?>
								</label>
							</div>
						</div>
					</div>

					<button type="submit" class="btn btn-primary">Salvar</button>
					
				</form>

			</div>
			<div class="col-12 col-sm-5">
				<?php if ($banner['IMG_BANNER']) : ?>
				<div class="mx-sm-5">
					<label class="small text-uppercase font-weight-bold">
						Banner
					</label>
					<div class="border">
						<img src="/uploads/<?= $banner['IMG_BANNER'] ?>" class="img-fluid">
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php else: ?>
		<div>
			<div class="alert alert-warning">Banner não encontrada.</div>
		</div>
		<?php endif; ?>

	</div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>