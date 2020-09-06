<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

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
			<h1 class="h3 my-0">Banners da página: <?= $empresa['NOME_EMPRESA']; ?></h1>
		</div>
	</header>

	<div class="row mb-5">
		<div class="col-sm-6">

		<form action="cadastrarBanner.php" method="post" enctype="multipart/form-data" autocomplete="off">

			<div class="form-group-video mb-3">
				<input type="hidden" name="empresa" value="<?= $idEmpresa; ?>">

				<div class="form-group">
					<label>Imagem</label>
					<div class="input-group">
						<div class="custom-file" lang="pt-br">
							<input type="file" class="custom-file-input" name="arquivo" id="inputGroupFile">
							<label class="custom-file-label" for="inputGroupFile"></label>
						</div>
					</div>
				</div>
			</div>

			<button type="submit" class="btn btn-primary">Salvar</button>

		</form>

		</div>
    </div>
    
    <div class="row">
    <?php
    $PDO = db_connect();
    $sql = "SELECT * FROM BANNERS WHERE EMPRESA_BANNER = :EMPRESA_BANNER ORDER BY ID_BANNER DESC";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':EMPRESA_BANNER', $idEmpresa, PDO::PARAM_INT);

    try{
        $stmt->execute();
        $arBanners = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar banners: " . $e->getMessage());
    }
    ?>

    <?php if (!empty($arBanners)) : ?>
        <?php foreach ($arBanners as $banner) : ?>
        <div class="col-12 col-sm-4">
            <div class="card">
                <img src="/uploads/<?= $banner['IMG_BANNER'] ?>" alt="<?= $banner['IMG_BANNER'] ?>" class="card-img-top">
                <div class="card-body">
                    <a href="#" class="btn btn-danger">Deletar</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    </div>
	
</main>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>