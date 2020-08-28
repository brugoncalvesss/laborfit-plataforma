<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

if (empty($id)) {
	die("#ID Não informado.");
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

        $sql = "SELECT *
                FROM USUARIOS WHERE ID_USUARIO = :ID_USUARIO";
        $request = $PDO->prepare($sql);
        $request->bindParam(':ID_USUARIO', $id, PDO::PARAM_INT);
        $request->execute();
        $usuario = $request->fetch(PDO::FETCH_ASSOC);
    ?>
    
    <?php if (!empty($usuario)) : ?>
    <div class="row mb-5">
        <div class="col-12 col-sm-7">
            
            <form action="/admin/usuarios/editarUsuario.php" method="post" autocomplete="off">

                <input type="hidden" class="form-control" name="id" value="<?= $usuario['ID_USUARIO'] ?>">
                
                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Empresa</label>
                    <select name="empresa" class="form-control">
                        <?php getSelectEmpresas($usuario['EMPRESA_USUARIO']); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Departamento</label>
                    <input type="text" class="form-control" name="departamento" value="<?= $usuario['DEPARTAMENTO_USUARIO'] ?>">
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Subdepartamento</label>
                    <input type="text" class="form-control" name="subdepartamento" value="<?= $usuario['SUBDEPARTAMENTO_USUARIO'] ?>">
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Nome completo</label>
                    <input type="text" class="form-control" name="nome" value="<?= $usuario['NOME_USUARIO'] ?>">
                </div>

                <div class="form-group">
                    <?php
                        $parts = explode('-', $usuario['DT_NASCIMENTO_USUARIO']);
                        $data = "$parts[2]/$parts[1]/$parts[0]";
                        $data = limparCaracteres($data);
                    ?>
                    <label class="small text-uppercase font-weight-bold">Data de nascimento</label>
                    <input type="text" class="form-control" name="nascimento" id="data" value="<?= $data ?>">
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Sexo</label>
                    <input type="text" class="form-control" name="sexo" value="<?= $usuario['SEXO_USUARIO'] ?>">
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">CPF</label>
                    <input type="text" class="form-control" name="cpf" id="cpf" value="<?= $usuario['CPF_USUARIO'] ?>" required>
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">E-mail</label>
                    <input type="email" class="form-control" name="email" value="<?= $usuario['EMAIL_USUARIO'] ?>">
                </div>

                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>

        </div>
    </div>
    <?php endif; ?>

</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>