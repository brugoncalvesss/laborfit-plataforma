<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'; ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Editar programa</h1>
		</div>
	</header>

    <?php
    $idPrograma = $_GET['idPrograma'];
    $idEtapa = $_GET['idEtapa'];
    $arEtapa = getEtapa($idEtapa, $idPrograma);
    ?>
    
    <div class="row mb-3">
        <div class="col-12 col-sm-7">

            <?php if (!empty($arEtapa)) : ?>
            <form action="/admin/etapas/put.php" method="post" autocomplete="off">

                <input type="hidden" name="ID_ETAPA" class="form-control" value="<?= $arEtapa['ID_ETAPA'] ?>">
                <input type="hidden" name="FK_PROGRAMA" class="form-control" value="<?= $arEtapa['FK_PROGRAMA'] ?>">

                <div class="form-group">
                    <label for="NOME_ETAPA">Nome</label>
                    <input type="text" name="NOME_ETAPA" class="form-control" value="<?= $arEtapa['NOME_ETAPA'] ?>">
                </div>

                <div class="form-group form-check">
                    <?php $checked = ($arEtapa['FL_PREMIO_ETAPA']) ? 'checked' : ''; ?>
                    <input type="checkbox" class="form-check-input" name="FL_PREMIO_ETAPA" value="1" id="FL_PREMIO_ETAPA" <?= $checked; ?>>
                    <label class="form-check-label" for="FL_PREMIO_ETAPA">Prêmio para dia completo?</label>
                </div>

                <div class="form-group">
                    <label for="ICON_ETAPA">Ícone personalizado</label>
                    <div class="input-group">
                        <div class="custom-file" lang="pt-br">
                            <input type="file" class="custom-file-input" name="ICON_ETAPA" id="inputGroupFile">
                            <label class="custom-file-label" for="inputGroupFile"><?= $arEtapa['ICON_ETAPA'] ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="POPUP_ETAPA">Popup personalizado</label>
                    <div class="input-group">
                        <div class="custom-file" lang="pt-br">
                            <input type="file" class="custom-file-input" name="POPUP_ETAPA" id="inputGroupFiles">
                            <label class="custom-file-label" for="inputGroupFiles"><?= $arEtapa['POPUP_ETAPA'] ?></label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>

            </form>
            <?php endif; ?>

        </div><!-- end col -->
    </div><!-- end row -->
	
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'; ?>