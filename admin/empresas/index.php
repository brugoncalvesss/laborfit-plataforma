<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Empresas</h1>
        </div>
        <div class="col text-sm-right">
            <a class="btn btn-primary btn-sm" href="/admin/empresas/nova.php">Nova</a>
        </div>
    </header>
    
    <div class="card mb-3">
        <?php
        $PDO = db_connect();

        $sql = "SELECT ID_EMPRESA, NOME_EMPRESA FROM EMPRESAS";
        $request = $PDO->prepare($sql);
        $request->execute();
        $arEmpresas = $request->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if (count($arEmpresas) > 0) : ?>
            <?php foreach ($arEmpresas as $empresa) : ?>
            <div class="row align-items-center no-gutters border-bottom pl-2">
                <div class="col">
                    <i class="far fa-building"></i>
                    <span><?= $empresa['NOME_EMPRESA']; ?></span>
                </div>
                <div class="col col-auto">
                    <a class="btn btn-link" href="/admin/empresas/editar.php?id=<?= $empresa['ID_EMPRESA']; ?>">
                        <i class="far fa-edit"></i>
                    </a>
                    <a class="btn btn-link" href="/admin/empresas/deletarEmpresa.php?id=<?= $empresa['ID_EMPRESA']; ?>">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>