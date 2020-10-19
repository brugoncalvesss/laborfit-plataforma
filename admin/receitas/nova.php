<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'; ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Nova Receita</h1>
        </div>
    </header>
    
    <div class="row mb-5">
        <div class="col-12 col-sm-7">

            <form action="/admin/receitas/put.php" method="post" enctype="multipart/form-data" autocomplete="off">

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="NOME_RECEITA" class="form-control">
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

                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="DESCRICAO_RECEITA" id="editor" class="form-control"></textarea>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="1" name="DESTAQUE_RECEITA" id="receitaCheck1">
                    <label class="form-check-label" for="receitaCheck1">
                        Receita em destaque?
                    </label>
                </div>

                <div class="form-group">
                    <label>Categoria</label>
                    <textarea id="tagCategoria" name='CATEGORIAS' class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>

            </form>

        </div>
    </div>

</main>


<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            language: 'pt-br',
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        })
        .catch(error => {
            console.error( error );
        });
</script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'; ?>