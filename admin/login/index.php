<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/_header.php'); ?>

<main class="bg-light">
	<div class="container">
		<div class="row align-items-center justify-content-center no-gutters min-vh-100">
			<div class="col-12 col-md-8 col-lg-5">

				<form action="/admin/login/login.php" method="post" class="mb-4" autocomplete="off">

					<div class="text-left">
						<h2 class="h2">Log In</h2>
					</div>

					<div class="form-group">
						<label class="small text-muted font-weight-bold mb-1" for="email">
							Email
						</label>
						<input type="email" class="form-control" name="email" id="email" value="bruno@google.com">
					</div>

					<div class="form-group">
						<label class="small text-muted font-weight-bold mb-1" for="password">
							Senha
						</label>
						<input type="password" class="form-control" name="password" id="password" value="123456">
					</div>

					<p class="text-right">
						<a class="btn btn-link" href="#./password-reset.php">Esqueceu sua senha?</a>
					</p>

					<button class="btn btn-block btn-primary" type="submit">Entrar</button>
					
				</form>

			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end container -->
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/_footer.php'); ?>