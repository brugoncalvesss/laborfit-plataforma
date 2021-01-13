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

		$destaque = getIdDestaqueVideo($id);
		$arrAula = getAulaDoPrograma($id);
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

					<div class="form-group">
						<label>Destaque</label>
						<select name="DESTAQUE_VIDEO" class="form-control">
							<option value="0">Sem destaque</option>
							<?= getOptionsDestaqueVideo($destaque[0]['ID_DESTAQUE']); ?>
						</select>
					</div>

					<div class="form-group">
						<label>Texto de destaque</label>
						<input type="text" name="INTRO_VIDEO" value="<?= $video['INTRO_VIDEO']; ?>" class="form-control">
					</div>

					<div class="card mb-3">
						<div class="card-header">
							Adicionar ao programa?
						</div>
						<div class="card-body">
							<div class="form-group">
								<label>Programa</label>
								<select name="ID_PROGRAMA" class="form-control">
									<option value="0">Selecionar</option>
									
									<?php $arrProgramas = getPrograma(); ?>
									<?php if (!empty($arrProgramas)) : ?>
										<?php foreach ($arrProgramas as $programa) : ?>
										<?php $selected = ($arrAula['FK_PROGRAMA'] == $programa['ID_PROGRAMA']) ? 'selected' : ''; ?>
										<option value="<?= $programa['ID_PROGRAMA'] ?>" <?= $selected ?>><?= $programa['NOME_PROGRAMA'] ?></option>
										<?php endforeach; ?>
									<?php endif; ?>

								</select>
							</div>

							<div class="form-group">
								<label>Dia</label>
								<input type="number" name="ID_ETAPA" class="form-control" value="<?= $arrAula['FK_ETAPA'] ?>" placeholder="Dia de exibição do vídeo">
							</div>
						</div>
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