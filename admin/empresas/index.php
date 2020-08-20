<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Empresas</h1>
        </div>
        <div class="col text-sm-right">
            <a class="btn btn-primary btn-sm" href="/admin/empresa/nova.php">Nova</a>
        </div>
    </header>
    
    <div class="card mb-3">
        <?php $a = 1; while ($a <= 5) : ?>
        <div class="row align-items-center border-bottom py-1 px-3 no-gutters">
            <div class="col">Nike</div>
            <div class="col col-auto">
                <a class="btn btn-link" href="#">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                <a class="btn btn-link" href="/admin/empresa/editar.php?id=<?= md5($a) ?>">
                    <i class="far fa-edit"></i>
                </a>
                <button id="deletarEmpresa" class="btn btn-link" data-id="<?= md5($a) ?>">
                    <i class="far fa-trash-alt"></i>
                </button>
            </div>
        </div>
        <?php $a++; endwhile; ?>
    </div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>