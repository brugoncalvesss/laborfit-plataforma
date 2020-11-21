<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Novo vídeo</h1>
		</div>
	</header>
	
    <div class="row mb-3">
        <div class="col-12 col-sm-7">
            
            <form action="/admin/paginas/cadastrarVideo.php" method="post" enctype="multipart/form-data" autocomplete="off">

                <div class="form-group">
                    <label>Nome do vídeo</label>
                    <input type="text" name="NOME_VIDEO" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Link do Vimeo</label>
                    <input type="url" name="LINK_VIDEO" class="form-control" required>
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
                    <label>Categoria</label>
                    <textarea id="tagCategoria" name='CATEGORIAS' class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Temas</label>
                    <textarea id="tagTema" name='TEMAS' class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="DESC_VIDEO" rows="3" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Destaque</label>
                    <select name="DESTAQUE_VIDEO" class="form-control">
                        <option value="0">Sem destaque</option>
                        <?= getOptionsDestaqueVideo(); ?>
                    </select>
                </div>

                <div id="defaultIntro" class="form-group d-none">
                    <label>Texto de destaque</label>
                    <input type="text" name="INTRO_VIDEO" value="" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
                
            </form>

        </div>
    </div><!-- end row -->
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>