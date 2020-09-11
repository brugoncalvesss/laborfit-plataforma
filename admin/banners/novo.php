<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$idEmpresa = $_GET['empresa'] ?: null;

if (empty($idEmpresa)) {
	die('#ID da empresa não informado.');
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Novo</h1>
		</div>
	</header>
	
	<div class="mb-3">
		<?php
		$PDO = db_connect();
		$sql = "SELECT * FROM CATEGORIAS WHERE ID_CATEGORIA = :ID_CATEGORIA";
		$stmt = $PDO->prepare($sql);
		$stmt->bindParam(':ID_CATEGORIA', $idEmpresa, PDO::PARAM_INT);
		
		try{
			$stmt->execute();
			$categoria = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception("Erro ao carregar categoria: " . $e->getMessage());
		}
		?>

		<?php if (!empty($categoria)) : ?>
		<div class="row mb-3">
			<div class="col-12 col-sm-7">
				
				<form action="/admin/banners/cadastrarBanner.php" enctype="multipart/form-data" method="post" autocomplete="off">

					<input type="hidden" name="empresa" value="<?= $categoria['ID_CATEGORIA']; ?>">

					<div class="form-group">
						<label class="small text-uppercase font-weight-bold">Link do banner</label>
						<input type="url" class="form-control" name="link">
					</div>

					<div class="form-group">
						<label class="small text-uppercase font-weight-bold">Banner</label>
						<div class="input-group">
							<div class="custom-file" lang="pt-br">
								<input type="file" class="custom-file-input" name="arquivo" id="inputGroupFile" required>
								<label class="custom-file-label" for="inputGroupFile"></label>
							</div>
						</div>
					</div>

					<button type="submit" class="btn btn-primary">Salvar</button>
					
				</form>

			</div>
		</div>
		<?php else: ?>
		<div>
			<div class="alert alert-warning">Categoria não encontrada.</div>
		</div>
		<?php endif; ?>

	</div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>