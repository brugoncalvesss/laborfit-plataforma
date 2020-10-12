<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');
$id = $_GET['id'] ?: null;

if (!$id) {
    die("Erro: #ID não informado.");
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Editar tema</h1>
        </div>
    </header>
    
    <div class="row mb-3">
        <div class="col-12 col-sm-7">

            <?php
            $PDO = db_connect();
            $sql = "SELECT * FROM
                        TEMAS
                    WHERE
                        TEMAS.ID_TEMA = :ID_TEMA
                    LIMIT 1";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':ID_TEMA', $id, PDO::PARAM_INT);
    
            try{
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                throw new Exception("Erro ao carregar os temas: " . $e->getMessage());
            }
            ?>

            <form action="/admin/temas/put.php" method="post" autocomplete="off">
                <input type="hidden" name="ID_TEMA" value="<?= $result['ID_TEMA']; ?>">
                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Nome</label>
                    <input type="text" class="form-control" name="NOME_TEMA" value="<?= $result['NOME_TEMA']; ?>" required>
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Descrição</label>
                    <textarea name="DESCRICAO_TEMA" class="form-control" rows="2"><?= $result['DESCRICAO_TEMA']; ?></textarea>
                </div>

                <button class="btn btn-primary">Salvar</button>
            </form>

        </div>
    </div>

</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>