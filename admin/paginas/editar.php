<?php
require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$id = $_GET['id'] ?: null;

if (empty($id)) {
	echo "#ID para alteração não definido.";
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
		$sql = "SELECT * FROM VIDEOS
				WHERE VIDEOS.ID_VIDEO = :ID_VIDEO";
		$stmt = $PDO->prepare($sql);
		$stmt->bindParam(':ID_VIDEO', $id, PDO::PARAM_INT);
		
		try{
			$stmt->execute();
			$video = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			throw new Exception("Erro ao carregar banner: " . $e->getMessage());
		}

		$arCategorias = getCategoriasByIdVideo($video['ID_VIDEO']);
		$categorias = '';
		if (!empty($arCategorias)) {
			$categorias = implode(
				', ',
				array_unique(array_column($arCategorias, 'NOME_CATEGORIA'))
			);
		}

		$arTemas = getTemasByIdVideo($video['ID_VIDEO']);
		$temas = '';
		if (!empty($arTemas)) {
			$temas = implode(
				', ',
				array_unique(array_column($arTemas, 'NOME_TEMA'))
			);
		}
		?>

		<?php if (!empty($video)) : ?>
		<div class="row mb-3">
			<div class="col-12 col-sm-7">
				
				<form action="/admin/paginas/editarVideo.php" enctype="multipart/form-data" method="post" autocomplete="off">

					<input type="hidden" name="id" value="<?= $video['ID_VIDEO'] ?>">

                    <div class="form-group">
                        <label>Nome do vídeo</label>
                        <input type="text" name="nome" class="form-control" value="<?= $video['NOME_VIDEO'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Link do Vimeo</label>
                        <input type="url" name="link" class="form-control" value="https://vimeo.com/<?= $video['LINK_VIDEO'] ?>" required>
                        <small id="linkHelpBlock" class="form-text text-muted">
                            Ex.: https://vimeo.com/65107797
                        </small>
                    </div>

                    <div class="form-group">
                        <label>Thumb do vídeo</label>
                        <input type="hidden" name="imagem" value="<?= $video['THUMB_VIDEO']; ?>">
                        <div class="input-group">
                            <div class="custom-file" lang="pt-br">
                                <input type="file" class="custom-file-input" name="arquivo" id="inputGroupFile">
                                <label class="custom-file-label" for="inputGroupFile"><?= $video['THUMB_VIDEO']; ?></label>
                            </div>
                        </div>
                    </div>

					<div class="form-group">
						<label>Categoria</label>
						<textarea id="tagCategoria" name='CATEGORIAS' class="form-control">
						<?= $categorias; ?>
						</textarea>
					</div>

					<div class="form-group">
						<label>Temas</label>
						<textarea id="tagTema" name='TEMAS' class="form-control">
						<?= $temas; ?>
						</textarea>
					</div>

                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="descricao" rows="3" class="form-control"><?= $video['DESC_VIDEO']; ?></textarea>
                    </div>

					<div class="form-check mb-3">
						<?php
						$checked = '';
						if ($video['DESTAQUE_VIDEO']) {
							$checked = 'checked';
						}
						?>
						<input class="form-check-input" type="checkbox" value="1" name="DESTAQUE_VIDEO" id="defaultCheck1" <?= $checked; ?>>
						<label class="form-check-label" for="defaultCheck1">
							Vídeo destaque?
						</label>
					</div>

					<?php
					$intro = 'd-none';
					if ($video['DESTAQUE_VIDEO']) {
						$intro = '';
					}
					?>
					<div id="defaultIntro" class="form-group <?= $intro; ?>">
						<label>Texto de destaque</label>
						<input type="text" name="INTRO_VIDEO" value="<?= $video['INTRO_VIDEO']; ?>" class="form-control">
					</div>

					<button class="btn btn-primary">Salvar</button>
					
				</form>

			</div>
			<div class="col-12 col-sm-5">
				<?php if ($video['THUMB_VIDEO']) : ?>
				<div class="mx-sm-5">
					<label class="small text-uppercase font-weight-bold">
						Thumb do vídeo
					</label>
					<div class="border">
						<img src="/uploads/<?= $video['THUMB_VIDEO']; ?>" class="img-fluid">
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>

	</div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>