<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

    <?php
    if ($_GET['id']) {
        $idEmpresa = $_GET['id'];
    } else {
        die("Erro: Empresa não encontrada.");
    }

    $PDO = db_connect();
    $sql = "SELECT ID_EMPRESA, NOME_EMPRESA FROM EMPRESAS WHERE ID_EMPRESA = :ID_EMPRESA";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_EMPRESA', $idEmpresa, PDO::PARAM_INT);
    
    try{
        $stmt->execute();
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar empresa: " . $e->getMessage());
    }
    ?>
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0"><?= $empresa['NOME_EMPRESA']; ?></h1>
        </div>
    </header>

    <div class="row">
        <div class="col-sm-6">

        <form action="cadastrarVideo.php" method="post" autocomplete="off">

            <div class="form-group-video mb-3">
                <input type="hidden" name="empresa" value="<?= $idEmpresa; ?>">
                <div class="form-group">
                    <label>Nome do vídeo</label>
                    <input type="text" name="nome" class="form-control" value="movie <?= rand(0, 30) ?>" required>
                </div>
                <div class="form-group">
                    <label>Link do youtube</label>
                    <input type="text" name="link" class="form-control" value="https://www.youtube.com/watch?v=Ds6SSB2RuVI" required>
                </div>
                <div class="form-group">
                    <label>Thumb do vídeo</label>
                    <input type="text" name="thumb" class="form-control" value="img.jpg">
                </div>
                <div class="form-group">
                    <label>Categoria</label>
                    <input type="text" name="categoria" class="form-control" value="1">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>

        </form>

        </div>
        <div class="col-sm-6">

            <ul class="list-group">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Morbi leo risus</li>
                <li class="list-group-item">Porta ac consectetur ac</li>
                <li class="list-group-item">Vestibulum at eros</li>
            </ul>

        </div>
    </div>
    
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>