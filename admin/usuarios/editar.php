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
                FROM USUARIOS WHERE ID_USUARIO = :ID_USUARIO LIMIT 1";
        $request = $PDO->prepare($sql);
        $request->bindParam(':ID_USUARIO', $id, PDO::PARAM_INT);
        $request->execute();
        $usuario = $request->fetch(PDO::FETCH_ASSOC);
    ?>
    
    <?php if (!empty($usuario)) : ?>
    <div class="row mb-5">
        <div class="col-12 col-sm-7">
            
            <form action="/admin/usuarios/editarUsuario.php" method="post" autocomplete="off">

                <input type="hidden" class="form-control" name="ID_USUARIO" value="<?= $usuario['ID_USUARIO'] ?>">

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Status do usuário</label>
                    <?php if ($usuario['STATUS_USUARIO']) : ?>
                        <span class="badge badge-success">Ativo</span>
                    <?php else : ?>
                        <span class="badge badge-secondary">Inativo</span>
                    <?php endif; ?>

                    <?php $ativar = ($usuario['STATUS_USUARIO']) ? 'Desativar usuário' : 'Ativar usuário'; ?>
                    <div class="float-right">
                        <a href="/admin/usuarios/status.php?id=<?= $usuario['ID_USUARIO'] ?>" class="btn btn-primary btn-sm">
                            <?= $ativar; ?>
                        </a>
                    </div>
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Departamento</label>
                    <input type="text" class="form-control" name="DEPARTAMENTO_USUARIO" value="<?= $usuario['DEPARTAMENTO_USUARIO'] ?>">
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Cargo</label>
                    <input type="text" name="CARGO_USUARIO" class="form-control" value="<?= $usuario['CARGO_USUARIO'] ?>">
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Como gostaria de ser chamado(a)?</label>
                    <input type="text" name="APELIDO_USUARIO" class="form-control" value="<?= $usuario['APELIDO_USUARIO'] ?>">
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Nome completo</label>
                    <input type="text" class="form-control" name="NOME_USUARIO" value="<?= $usuario['NOME_USUARIO'] ?>">
                </div>

                <div class="form-group">
                    <?php
                        $parts = explode('-', $usuario['DT_NASCIMENTO_USUARIO']);
                        $data = "$parts[2]/$parts[1]/$parts[0]";
                        $data = limparCaracteres($data);
                    ?>
                    <label class="small text-uppercase font-weight-bold">Data de nascimento</label>
                    <input type="text" class="form-control" name="DT_NASCIMENTO_USUARIO" id="data" value="<?= $data ?>">
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Sexo</label>
                    <select name="SEXO_USUARIO" class="form-control">
                        <option value="<?= $usuario['SEXO_USUARIO'] ?>"><?= $usuario['SEXO_USUARIO'] ?></option>
                        <option value="Feminino">Feminino</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Não Definido">Não Definido</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">CPF</label>
                    <input type="text" class="form-control" name="CPF_USUARIO" id="cpf" value="<?= $usuario['CPF_USUARIO'] ?>" required>
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">E-mail</label>
                    <input type="email" class="form-control" name="EMAIL_USUARIO" value="<?= $usuario['EMAIL_USUARIO'] ?>">
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Empresa</label>
                    <select name="EMPRESA_USUARIO" class="form-control">
                        <option value="0">Selecionar</option>
                        <?php getSelectEmpresas($usuario['EMPRESA_USUARIO']); ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>

        </div>
    </div>
    <?php endif; ?>

</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>