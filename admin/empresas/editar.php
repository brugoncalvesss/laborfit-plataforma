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
            <h1 class="h3 my-0">Editar empresa</h1>
        </div>
    </header>

    <?php
        $PDO = db_connect();

        $sql = "SELECT ID_EMPRESA, NOME_EMPRESA FROM EMPRESAS WHERE ID_EMPRESA = :ID_EMPRESA";
        $request = $PDO->prepare($sql);
        $request->bindParam(':ID_EMPRESA', $id, PDO::PARAM_INT);
        $request->execute();
        $empresa = $request->fetch(PDO::FETCH_ASSOC);
    ?>
    
    <?php if (!empty($empresa)) : ?>
    <div class="row mb-3">
        <div class="col-12 col-sm-7">
            
            <form action="/admin/empresas/editarEmpresa.php" method="post" autocomplete="off">

                <input type="hidden" name="id" value="<?= $empresa['ID_EMPRESA'] ?>">

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Nome</label>
                    <input type="text" class="form-control" name="empresa" minlenght="2" value="<?= $empresa['NOME_EMPRESA'] ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>

        </div>
    </div>
    <?php else: ?>
    <div>
        <p>Empresa não encontrada.</p>
    </div>
    <?php endif; ?>

</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>