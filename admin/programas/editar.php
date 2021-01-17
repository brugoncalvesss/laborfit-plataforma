<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'; ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Editar programa</h1>
		</div>
	</header>

    <?php
    $idPrograma = $_GET['id'];
    $arPrograma = getPrograma($idPrograma);
    ?>
    
    <div class="row mb-3">
        <div class="col-12 col-sm-7">

            <?php if (!empty($arPrograma)) : ?>
            <form action="/admin/programas/put.php" method="post" autocomplete="off">

                <input type="hidden" name="ID_PROGRAMA" class="form-control" value="<?= $arPrograma[0]['ID_PROGRAMA'] ?>">

                <div class="form-group">
                    <label for="NOME_PROGRAMA">Nome do programa</label>
                    <input type="text" name="NOME_PROGRAMA" class="form-control" value="<?= $arPrograma[0]['NOME_PROGRAMA'] ?>">
                </div>

                <div class="form-group">
                    <label for="VIMEO_PROGRAMA">Link do vimeo</label>
                    <input type="text" name="VIMEO_PROGRAMA" class="form-control" value="https://vimeo.com/<?= $arPrograma[0]['VIMEO_PROGRAMA'] ?>">
                </div>

                <div class="form-group">
                    <label for="DESCRICAO_PROGRAMA">Descrição</label>
                    <input type="text" name="DESCRICAO_PROGRAMA" class="form-control" value="<?= $arPrograma[0]['DESCRICAO_PROGRAMA'] ?>">
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>

            </form>
            <?php endif; ?>

        </div><!-- end col -->
    </div><!-- end row -->
	
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'; ?>