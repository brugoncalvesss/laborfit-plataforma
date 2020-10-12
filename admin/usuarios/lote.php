<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Cadastro de usuários em lote</h1>
        </div>
    </header>
    
    <div class="row mb-3">
        <div class="col-12 col-sm-7">

            <form action="/admin/usuarios/putLote.php" method="post" enctype="multipart/form-data" autocomplete="off">

                <div class="form-group">
                    <label>Arquivo</label>
                    <div class="input-group">
                        <div class="custom-file" lang="pt-br">
                            <input type="file" class="custom-file-input" name="arquivo" id="inputGroupFile">
                            <label class="custom-file-label" for="inputGroupFile"></label>
                        </div>
                    </div>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        <p><a href="#">Clique aqui</a> para baixar o arquivo <code>.csv</code></p>
                    </small>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>

        </div>
    </div>

</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>