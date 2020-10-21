<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'; ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Receitas em destaque</h1>
        </div>
    </header>
    
    <div class="card mb-3">
        <?php

        $PDO = db_connect();
        $sql = "SELECT * FROM RECEITAS
                WHERE
                    RECEITAS.DESTAQUE_RECEITA = 1
                ORDER BY
                    RECEITAS.EXIBICAO_RECEITA
                ASC";
        $stmt = $PDO->prepare($sql);
        
        try{
            $stmt->execute();
            $arDestaques = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception("Erro ao carregar destaques: " . $e->getMessage());
        }
        ?>

        <div id="sortableReceitas">
        <?php if (count($arDestaques) > 0) : ?>
            <?php foreach ($arDestaques as $destaque) : ?>
            <div data-id="<?= $destaque['ID_RECEITA'] ?>" class="row align-items-center no-gutters border-bottom p-2" style="cursor: pointer;">
                <div class="col">
                    <i class="fas fa-sort mr-2"></i>
                    <span><?= $destaque['NOME_RECEITA'] ?></span>
                </div>
                <div class="col col-auto">
                    <?php
                    $data = explode('-', $destaque['EXIBICAO_RECEITA']);
                    echo $data[2] . "/" . $data[1] . "/" . $data[0];
                    ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>

    </div>
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'; ?>