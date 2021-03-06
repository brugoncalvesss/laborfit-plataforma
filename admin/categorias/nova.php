<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Nova categoria</h1>
        </div>
    </header>
    
    <div class="row mb-3">
        <div class="col-12 col-sm-7">

            <form action="/admin/categorias/cadastrarCategoria.php" method="post" enctype="multipart/form-data" autocomplete="off">

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Nome da categoria</label>
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