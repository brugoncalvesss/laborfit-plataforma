<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Novo usuário</h1>
        </div>
    </header>
    
    <div class="row">
        <div class="col-12 col-sm-7">
            <div class="card mb-3">
                <div class="card-body">
                    <form action="#">
                        <div class="form-group">
                            <label class="small text-muted text-uppercase font-weight-bold mb-1" for="cpf">
                                CPF
                            </label>
                            <input type="text" class="form-control" id="cpf" required>
                        </div>
                        <div class="form-group">
                            <label class="small text-muted text-uppercase font-weight-bold mb-1" for="nome">
                                Nome
                            </label>
                            <input type="text" class="form-control" id="nome">
                        </div>
                        <div class="form-group">
                            <label class="small text-muted text-uppercase font-weight-bold mb-1" for="email">
                                E-mail
                            </label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label class="small text-muted text-uppercase font-weight-bold mb-1" for="empresa">
                                Empresa
                            </label>
                            <input type="text" class="form-control" id="empresa">
                        </div>
                        <button class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>