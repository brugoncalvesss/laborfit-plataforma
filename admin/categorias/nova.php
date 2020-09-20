<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Novo álbum</h1>
        </div>
    </header>
    
    <div class="row mb-3">
        <div class="col-12 col-sm-7">

            <form action="/admin/categorias/cadastrarCategoria.php" method="post" enctype="multipart/form-data" autocomplete="off">

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Nome do álbum</label>
                    <input type="text" class="form-control" name="nome" required>
                </div>

				<div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Capa</label>
					<div class="input-group">
						<div class="custom-file" lang="pt-br">
							<input type="file" class="custom-file-input" name="arquivo" id="inputGroupFile">
							<label class="custom-file-label" for="inputGroupFile"></label>
						</div>
					</div>
				</div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="1" name="destaque" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Álbum destaque?
                    </label>
                </div>

                <div class="form-group mb-4">
                    <label class="small text-uppercase font-weight-bold">Descrição</label>
                    <textarea name="descricao" rows="2" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>

        </div>
    </div>

</main>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>