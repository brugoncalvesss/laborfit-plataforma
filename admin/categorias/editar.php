<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

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
		$sql = "SELECT * FROM CATEGORIAS WHERE ID_CATEGORIA = :ID_CATEGORIA";
		$stmt = $PDO->prepare($sql);
		$stmt->bindParam(':ID_CATEGORIA', $id, PDO::PARAM_INT);
		
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
				
				<form action="/admin/categorias/editarCategoria.php" enctype="multipart/form-data" method="post" autocomplete="off">

					<input type="hidden" name="id" value="<?= $categoria['ID_CATEGORIA'] ?>">

					<div class="form-group">
						<label class="small text-uppercase font-weight-bold">Nome da categoria</label>
						<input type="text" class="form-control" name="nome" value="<?= $categoria['NOME_CATEGORIA'] ?>" required>
					</div>

					<div class="form-group">
						<input type="hidden" name="imagem" value="<?= $categoria['IMG_CATEGORIA'] ?>">
						<label class="small text-uppercase font-weight-bold">Capa</label>
						<div class="input-group">
							<div class="custom-file" lang="pt-br">
								<input type="file" class="custom-file-input" name="arquivo" id="inputGroupFile">
								<label class="custom-file-label" for="inputGroupFile">
								<?= $categoria['IMG_CATEGORIA'] ?>
								</label>
							</div>
						</div>
					</div>

					<div class="form-group mb-4">
						<label class="small text-uppercase font-weight-bold">Descrição</label>
						<textarea name="descricao" rows="2" class="form-control"><?= $categoria['DESC_CATEGORIA']; ?></textarea>
					</div>

					<button type="submit" class="btn btn-primary">Salvar</button>
					
				</form>

			</div>
			<div class="col-12 col-sm-5">
				<?php if ($categoria['IMG_CATEGORIA']) : ?>
				<div class="mx-sm-5">
					<label class="small text-uppercase font-weight-bold">
						Capa
					</label>
					<div class="border">
						<img src="/uploads/<?= $categoria['IMG_CATEGORIA'] ?>" alt="<?= $categoria['NOME_CATEGORIA'] ?>" class="img-fluid">
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php else: ?>
		<div>
			<div class="alert alert-warning">Álbum não encontrado.</div>
		</div>
		<?php endif; ?>

	</div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>