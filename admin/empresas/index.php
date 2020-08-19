<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Empresas</h1>
        </div>
        <div class="col text-sm-right">
            <button class="btn btn-primary btn-sm">Nova</button>
        </div>
    </header>
    
    <div class="card mb-3">
        <?php while ($a <= 5) : ?>
        <div class="row align-items-center border-bottom py-1 px-3 no-gutters">
            <div class="col">Nike</div>
            <div class="col col-auto">
                <a class="btn btn-link" href="#">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                <a class="btn btn-link" href="#">
                    <i class="far fa-edit"></i>
                </a>
                <a class="btn btn-link" href="#">
                    <i class="far fa-trash-alt"></i>
                </a>
            </div>
        </div>
        <?php $a++; endwhile; ?>
    </div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>