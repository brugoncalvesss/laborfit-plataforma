<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Páginas</h1>
        </div>
    </header>
    
    <div class="card mb-3">
        <?php
        $PDO = db_connect();
        $sql = "SELECT ID_EMPRESA, NOME_EMPRESA FROM EMPRESAS";
        $stmt = $PDO->prepare($sql);
        
        try{
            $stmt->execute();
            $arEmpresas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception("Erro ao carregar empresas: " . $e->getMessage());
        }
        ?>

        <?php if (count($arEmpresas) > 0) : ?>
            <?php foreach ($arEmpresas as $empresa) : ?>
            <div class="row align-items-center no-gutters border-bottom pl-2">
                <div class="col">
                    <span><?= $empresa['NOME_EMPRESA'] ?></span>
                </div>
                <div class="col col-auto">
                    <a class="btn btn-link" href="/admin/paginas/lista.php?id=<?= $empresa['ID_EMPRESA'] ?>">
                        <i class="far fa-edit"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>