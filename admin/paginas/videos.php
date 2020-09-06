<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

	<?php
	if ($_GET['id']) {
		$idEmpresa = $_GET['id'];
	} else {
		die("Erro: Empresa não encontrada.");
	}

	$PDO = db_connect();
	$sql = "SELECT ID_EMPRESA, NOME_EMPRESA FROM EMPRESAS WHERE ID_EMPRESA = :ID_EMPRESA";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':ID_EMPRESA', $idEmpresa, PDO::PARAM_INT);
	
	try{
		$stmt->execute();
		$empresa = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch(PDOException $e) {
		throw new Exception("Erro ao carregar empresa: " . $e->getMessage());
	}
	?>
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Página de vídeos: <?= $empresa['NOME_EMPRESA']; ?></h1>
		</div>
	</header>

	<div class="row">
		<div class="col-sm-6">

		<form action="cadastrarVideo.php" method="post" enctype="multipart/form-data" autocomplete="off">

			<div class="form-group-video mb-3">
				<input type="hidden" name="empresa" value="<?= $idEmpresa; ?>">
				<div class="form-group">
					<label>Nome do vídeo</label>
					<input type="text" name="nome" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Link do Vimeo</label>
					<input type="text" name="link" class="form-control" required>
					<small id="linkHelpBlock" class="form-text text-muted">
						Ex.: https://vimeo.com/65107797
					</small>
				</div>
				<div class="form-group">
					<label>Thumb do vídeo</label>
					<div class="input-group">
						<div class="custom-file" lang="pt-br">
							<input type="file" class="custom-file-input" name="arquivo" id="inputGroupFile">
							<label class="custom-file-label" for="inputGroupFile"></label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<?php
					$PDO = db_connect();
					$sql = "SELECT ID_CATEGORIA, NOME_CATEGORIA FROM CATEGORIAS";
					$stmt = $PDO->prepare($sql);
					
					try{
						$stmt->execute();
						$arCategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
					} catch(PDOException $e) {
						throw new Exception("Erro ao carregar categorias: " . $e->getMessage());
					}
					?>
					<label>Categoria</label>
					<select name="categoria" class="form-control">
						<option value="0">Sem categoria</option>
						<?php foreach ($arCategorias as $categoria) : ?>
						<option value="<?= $categoria['ID_CATEGORIA'] ?>"><?= $categoria['NOME_CATEGORIA'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<button type="submit" class="btn btn-primary">Salvar</button>

		</form>

		</div>
		<div class="col-sm-6">

			<?php
			$PDO = db_connect();
			$sql = "SELECT
						ID_VIDEO, NOME_VIDEO, EMPRESA_VIDEO
					FROM
						VIDEOS
					WHERE EMPRESA_VIDEO = :EMPRESA_VIDEO
					ORDER BY ID_VIDEO DESC";

			$stmt = $PDO->prepare($sql);
			$stmt->bindParam(':EMPRESA_VIDEO', $idEmpresa, PDO::PARAM_INT);
			$stmt->execute();
			$arVideos = $stmt->fetchAll(PDO::FETCH_ASSOC);
			?>

			<?php if (!empty($arVideos)) : ?>
			<ul class="list-group">
				<?php foreach ($arVideos as $video) : ?>
				<li class="list-group-item d-flex justify-content-between align-items-center py-1">
					<?= $video['NOME_VIDEO'] ?>
					<a class="btn btn-link" href="/admin/paginas/deletarVideo.php?id=<?= $video['ID_VIDEO'] ?>&empresa=<?= $video['EMPRESA_VIDEO'] ?>">
						<i class="far fa-trash-alt"></i>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php else: ?>
			<p>Nenhum vídeo adicionado.</p>
			<?php endif; ?>

		</div>
	</div>
	
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>