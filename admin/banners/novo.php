<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
	
	<header class="row my-3">
		<div class="col">
			<h1 class="h3 my-0">Novo</h1>
		</div>
	</header>
	
	<div class="row mb-3">
		<div class="col-12 col-sm-7">
			
			<form action="/admin/banners/cadastrarBanner.php" enctype="multipart/form-data" method="post" autocomplete="off">

				<div class="form-group">
					<label class="small text-uppercase font-weight-bold">Link do banner</label>
					<input type="url" class="form-control" name="LINK_BANNER">
				</div>

				<div class="form-group">
					<label class="small text-uppercase font-weight-bold">Banner</label>
					<div class="input-group">
						<div class="custom-file" lang="pt-br">
							<input type="file" class="custom-file-input" name="arquivo" id="inputGroupFile" required>
							<label class="custom-file-label" for="inputGroupFile"></label>
						</div>
					</div>
				</div>

				<button type="submit" class="btn btn-primary">Salvar</button>
				
			</form>

		</div>
	</div>

</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>