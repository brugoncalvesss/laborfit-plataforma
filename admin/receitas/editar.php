<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'; ?>

<?php
$idReceita = isset($_GET['id']) ? $_GET['id'] : null;

if (!$idReceita) {
    die("#ID não encontrado.");
}

$PDO = db_connect();
$sql = "SELECT * FROM RECEITAS
        WHERE ID_RECEITA = :ID_RECEITA
        LIMIT 1";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_RECEITA', $idReceita);

if ($stmt->execute()) {
    $arReceitas = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    die("Receita não encontrada.");
}

$arCategorias = getCategoriasByIdReceita($arReceitas['ID_RECEITA']);
$categorias = '';
if (!empty($arCategorias)) {
    $categorias = implode(
        ', ',
        array_unique(array_column($arCategorias, 'NOME_CATEGORIA'))
    );
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Editar</h1>
        </div>
    </header>
    
    <div class="row mb-5">
        <div class="col-12 col-sm-7">

            <form action="/admin/receitas/post.php" method="post" enctype="multipart/form-data" autocomplete="off">

                <div class="form-group d-none">
                    <input type="hidden" name="ID_RECEITA" value="<?= $arReceitas['ID_RECEITA']; ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="NOME_RECEITA" value="<?= $arReceitas['NOME_RECEITA']; ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold">Capa</label>
                    <input type="hidden" name="IMG_RECEITA" value="<?= $arReceitas['IMG_RECEITA'] ?>">
					<div class="input-group">
						<div class="custom-file" lang="pt-br">
							<input type="file" class="custom-file-input" name="arquivo" id="inputGroupFile">
							<label class="custom-file-label" for="inputGroupFile"><?= $arReceitas['IMG_RECEITA'] ?></label>
						</div>
					</div>
				</div>

                <div class="form-group">
                    <label>Descrição</label>
                    <?php $descricao = str_replace('&', '&amp;', $arReceitas['DESCRICAO_RECEITA']); ?>
                    <textarea name="DESCRICAO_RECEITA" id="editor" class="form-control"><?= $descricao; ?></textarea>
                </div>

                <div class="form-check mb-3">
						<?php
						$checked = '';
						if ($arReceitas['DESTAQUE_RECEITA']) {
							$checked = 'checked';
						}
						?>
						<input class="form-check-input" type="checkbox" value="1" name="DESTAQUE_RECEITA" id="receitaCheck1" <?= $checked; ?>>
						<label class="form-check-label" for="receitaCheck1">
							Receita em destaque?
						</label>
					</div>

                <div class="form-group">
                    <label>Categoria</label>
                    <textarea id="tagCategoria" name='CATEGORIAS' class="form-control"><?= $categorias; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>

            </form>

        </div>
        <div class="col-12 col-sm-5">
            <?php if ($arReceitas['IMG_RECEITA']) : ?>
            <div class="mx-sm-5">
                <label>Capa</label>
                <div class="border">
                    <img src="/uploads/<?= $arReceitas['IMG_RECEITA'] ?>" alt="<?= $arReceitas['NOME_RECEITA'] ?>" class="img-fluid">
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

</main>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            language: 'pt-br',
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        })
        .catch(error => {
            console.error( error );
        });
</script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'; ?>