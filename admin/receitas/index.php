<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'; ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Receitas</h1>
        </div>
        <div class="col text-sm-right">
            <a class="btn btn-primary btn-sm" href="/admin/receitas/nova.php">Nova</a>
        </div>
    </header>
    
    <div class="card mb-3">
        <?php
        $PDO = db_connect();
        $sql = "SELECT * FROM RECEITAS ORDER BY NOME_RECEITA ASC";
        $stmt = $PDO->prepare($sql);
        
        try{
            $stmt->execute();
            $arReceitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception("Erro ao carregar categorias: " . $e->getMessage());
        }
        ?>

        <?php if (count($arReceitas) > 0) : ?>
            <?php foreach ($arReceitas as $receita) : ?>
            <div class="row align-items-center no-gutters border-bottom pl-2">
                <div class="col">
                    <span><?= $receita['NOME_RECEITA']; ?></span>
                </div>
                <div class="col col-auto">
                    <a class="btn btn-link" href="/admin/receitas/editar.php?id=<?= $receita['ID_RECEITA']; ?>">
                        <i class="far fa-edit"></i>
                    </a>
                    <a class="btn btn-link" href="/admin/receitas/delete.php?id=<?= $receita['ID_RECEITA']; ?>">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'; ?>