<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

$alerta = false;
$alerta_class = '';
$mensagem = '';
if (isset($_GET['status'])) {

    if ($_GET['status'] == 1) {
        $alerta = true;
        $mensagem = 'Preencha todos os campos.';
        $alerta_class = 'alert-danger';
    }

    if ($_GET['status'] == 2) {
        $alerta = true;
        $mensagem = 'Erro ao salvar dados.';
        $alerta_class = 'alert-warning';
    }

    if ($_GET['status'] == 3) {
        $alerta = true;
        $mensagem = 'Operação efetuada com sucesso.';
        $alerta_class = 'alert-success';
    }

}

?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Usuários</h1>
        </div>
        <div class="col text-sm-right">
            <a class="btn btn-primary btn-sm" href="/admin/usuarios/novo.php">Novo</a>
        </div>
    </header>

    <?php if ($alerta) : ?>
    <div class="alert alert-dismissible fade show <?= $alerta_class; ?>" role="alert">
        <?= $mensagem ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
    
    <div class="card mb-3">
        <?php
        $PDO = db_connect();

        $sql = "SELECT ID_USUARIO, CPF_USUARIO, NOME_USUARIO, EMAIL_USUARIO, EMPRESA_USUARIO, STATUS_USUARIO FROM USUARIOS";
        $request = $PDO->prepare($sql);
        $request->execute();
        $arUsuarios = $request->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if (count($arUsuarios) > 0) : ?>
            <?php foreach ($arUsuarios as $usuario) : ?>
            <div class="row align-items-center no-gutters border-bottom pl-2">
                <div class="col">
                    <i class="far fa-user"></i>
                    <span><?= formatCnpjCpf($usuario['CPF_USUARIO']) ?></span>
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