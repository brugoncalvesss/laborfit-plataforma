<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

if (empty($id)) {
	echo "ID para alteração não definido.";
	exit;
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Editar usuário</h1>
        </div>
    </header>

    <?php
        $PDO = db_connect();

        $sql = "SELECT ID_USUARIO, CPF_USUARIO, NOME_USUARIO, EMAIL_USUARIO, EMPRESA_USUARIO, STATUS_USUARIO
                FROM USUARIOS WHERE ID_USUARIO = :ID_USUARIO";
        $request = $PDO->prepare($sql);
        $request->bindParam(':ID_USUARIO', $id, PDO::PARAM_INT);
        $request->execute();
        $usuario = $request->fetch(PDO::FETCH_ASSOC);
    ?>
    
    <?php if (count($usuario)) : ?>
    <div class="row mb-3">
        <div class="col-12 col-sm-7">
            
            <form action="/admin/usuarios/editarUsuario.php" method="post">

                <input type="hidden" class="form-control" name="id" value="<?= $usuario['ID_USUARIO'] ?>">

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">CPF</label>
                    <input type="text" class="form-control" name="cpf" id="cpf" value="<?= $usuario['CPF_USUARIO'] ?>" required>
                </div>
                <div class="form-group">
                <label class="small text-uppercase font-weight-bold">Nome</label>
                    <input type="text" class="form-control" name="nome" value="<?= $usuario['NOME_USUARIO'] ?>">
                </div>
                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">E-mail</label>
                    <input type="email" class="form-control" name="email" value="<?= $usuario['EMAIL_USUARIO'] ?>">
                </div>
                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Empresa</label>
                    <input type="text" class="form-control" name="empresa" value="<?= $usuario['EMPRESA_USUARIO'] ?>">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>

        </div>
    </div>
    <?php endif; ?>

</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>