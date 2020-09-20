<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Novo vídeo</h1>
		</div>
	</header>
	
    <div class="row mb-3">
        <div class="col-12 col-sm-7">
            
            <form action="/admin/paginas/cadastrarVideo.php" enctype="multipart/form-data" method="post" autocomplete="off">

                <div class="form-group">
                    <label>Nome do vídeo</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Link do Vimeo</label>
                    <input type="url" name="link" class="form-control" required>
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
                    <label>Álbum do vídeo</label>
                    <select name="album" class="form-control">
                        <option value="0">Sem álbum</option>
                        <?php carregarSelectAlbuns(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tema</label>
                    <select name="TEMA_VIDEO" class="form-control">
                        <option value="0">Sem tema</option>
                        <?php carregarSelectTemas(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" rows="3" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
                
            </form>

        </div>
    </div><!-- end row -->
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>