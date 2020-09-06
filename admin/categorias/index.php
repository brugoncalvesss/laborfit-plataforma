<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Categorias</h1>
        </div>
        <div class="col text-sm-right">
            <a class="btn btn-primary btn-sm" href="/admin/categorias/nova.php">Nova</a>
        </div>
    </header>
    
    <div class="card mb-3">
        <?php
        $PDO = db_connect();
        $sql = "SELECT ID_CATEGORIA, NOME_CATEGORIA FROM CATEGORIAS";
        $stmt = $PDO->prepare($sql);
        
        try{
            $stmt->execute();
            $arCategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception("Erro ao carregar categorias: " . $e->getMessage());
        }
        ?>

        <?php if (count($arCategorias) > 0) : ?>
            <?php foreach ($arCategorias as $categoria) : ?>
            <div class="row align-items-center no-gutters border-bottom pl-2">
                <div class="col">
                    <span><?= $categoria['NOME_CATEGORIA'] ?></span>
                </div>
                <div class="col col-auto">
                    <a class="btn btn-link" href="/admin/categorias/deletarCategoria.php?id=<?= $categoria['ID_CATEGORIA'] ?>">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>