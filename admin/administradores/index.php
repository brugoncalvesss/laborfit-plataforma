<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Administradores</h1>
        </div>
        <div class="col text-sm-right">
            <a class="btn btn-primary btn-sm" href="/admin/administradores/novo.php">Novo</a>
        </div>
    </header>
    
    <div class="card mb-3">
        <?php
        $PDO = db_connect();

        if ($_SESSION['SUPER_ADMIN']) {
            $sql = "SELECT * FROM
                    ADMINS
                WHERE
                    EMPRESA_ADMIN = :EMPRESA_ADMIN";
        } else {
            $sql = "SELECT * FROM
                        ADMINS
                    WHERE
                        EMPRESA_ADMIN = :EMPRESA_ADMIN
                        AND SUPER_ADMIN <> 1";
        }

        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':EMPRESA_ADMIN', $_SESSION['ID_EMPRESA']);
    
        try{
            $stmt->execute();
            $arResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception("Erro ao carregar admins: " . $e->getMessage());
        }
        ?>

        <?php if (count($arResult) > 0) : ?>
            <?php foreach ($arResult as $usuario) : ?>
            <div class="row align-items-center no-gutters border-bottom pl-2">
                <div class="col">
                    <span><?= $usuario['EMAIL_ADMIN'] ?></span>
                </div>
                <div class="col col-auto">
                    <a class="btn btn-link" href="/admin/administradores/deletarAdmin.php?id=<?= $usuario['ID_ADMIN'] ?>">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>