<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Destaques</h1>
        </div>
    </header>
    
    <div class="card mb-3">
        <?php
        $PDO = db_connect();
        $sql = "SELECT * FROM DESTAQUES ORDER BY ID_DESTAQUE DESC";
        $stmt = $PDO->prepare($sql);
        
        try{
            $stmt->execute();
            $arDestaques = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception("Erro ao carregar categorias: " . $e->getMessage());
        }
        ?>

        <?php if (count($arDestaques) > 0) : ?>
            <?php foreach ($arDestaques as $destaque) : ?>
            <div class="row align-items-center no-gutters border-bottom pl-2">
                <div class="col">
                    <span><?= $destaque['NOME_DESTAQUE'] ?></span>
                </div>
                <div class="col col-auto">
                    <?php if($destaque['ID_DESTAQUE'] == 1) : ?>
                        <a class="btn btn-link" href="/admin/destaques/receitas.php?id=<?= $destaque['ID_DESTAQUE']; ?>">
                        Organizar receitas <i class="fas fa-sort-amount-up"></i>
                    </a>
                    <?php else : ?>
                    <a class="btn btn-link" href="/admin/destaques/ordem.php?id=<?= $destaque['ID_DESTAQUE']; ?>">
                        Organizar vídeos <i class="fas fa-sort-amount-up"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>