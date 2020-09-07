<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Novo administrador</h1>
        </div>
    </header>
    
    <div class="row mb-3">
        <div class="col-12 col-sm-7">

            <form action="/admin/administradores/cadastrarAdmin.php" method="post" autocomplete="off">
                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">E-mail</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Senha</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button class="btn btn-primary">Salvar</button>
            </form>

        </div>
    </div>

</main>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>