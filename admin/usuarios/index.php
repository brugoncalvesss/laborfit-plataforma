<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Usuários</h1>
        </div>
        <div class="col text-sm-right">
            <a class="btn btn-secondary btn-sm" href="/admin/usuarios/lote.php">Cadastrar em lote</a>
            <a class="btn btn-primary btn-sm" href="/admin/usuarios/novo.php">Novo</a>
        </div>
    </header>
    
    <div class="card mb-3">
    <?php
        $PDO = db_connect();
        $sql = "SELECT * FROM USUARIOS WHERE USUARIOS.STATUS_USUARIO != -1 ORDER BY USUARIOS.NOME_USUARIO ASC";
        $stmt = $PDO->prepare($sql);
    
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
                    <i class="far fa-user mr-2"></i>
                    <span><?= $usuario['NOME_USUARIO'] ?></span>
                </div>
                <div class="col col-auto">
                    <a class="btn btn-link" href="/admin/usuarios/editar.php?id=<?= $usuario['ID_USUARIO'] ?>">
                        <i class="far fa-edit"></i>
                    </a>
                    <a class="btn btn-link" href="/admin/usuarios/deletarUsuario.php?id=<?= $usuario['ID_USUARIO'] ?>">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>