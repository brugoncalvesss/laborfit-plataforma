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

                <div class="form-group">
                    <label>Destaque</label>
                    <select name="DESTAQUE_RECEITA" class="form-control">
                        <option value="0">Sem destaque</option>
                        <?= getOptionsDestaqueReceita(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Categoria</label>
                    <textarea id="tagCategoria" name='CATEGORIAS' class="form-control"></textarea>
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
                                    <option value="<?= $programa['ID_PROGRAMA'] ?>"><?= $programa['NOME_PROGRAMA'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label>Dia</label>
                            <input type="number" name="ID_ETAPA" class="form-control" placeholder="Dia de exibição do vídeo">
                        </div>
                    </div>
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