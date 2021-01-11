<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'; ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Novo programa</h1>
		</div>
	</header>
    
    <div class="row mb-3">
        <div class="col-12 col-sm-7">

            <form action="/admin/programas/post.php" method="post" autocomplete="off">

                <div class="form-group">
                    <label for="NOME_PROGRAMA">Nome</label>
                    <input type="text" name="NOME_PROGRAMA" class="form-control">
                </div>

                <div class="form-group">
                    <label for="DIAS_PROGRAMA">Quantidade de etapas</label>
                    <input type="number" name="DIAS_PROGRAMA" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>

            </form>

        </div><!-- end col -->
    </div><!-- end row -->
	
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'; ?>