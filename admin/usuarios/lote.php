<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Cadastro de usuários em lote</h1>
        </div>
    </header>
    
    <div class="row mb-3">
        <div class="col-12 col-sm-7">

            <form action="/admin/usuarios/loteUsuario.php" method="post" autocomplete="off">
                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">CPF</label>
                    <textarea name="CPF_USUARIO" rows="4" class="form-control" required></textarea>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        <p>Lista de CPFs separados por <code>;</code>(ponto e vírgula)</p>
                        <p>498.957.172-02;<br>492.839.992-74;<br>216.336.663-44;<br>511.375.765-96;<br>...</p>
                    </small>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>

        </div>
    </div>

</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>