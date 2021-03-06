<?php
ob_start();
session_start();
?>
<!doctype html>
<html lang="pt-br">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

		<!-- FontAwesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
		
		<link rel="stylesheet" href="/admin/css/style.css">

		<title>LogIn</title>
	</head>
	<body>

<main class="bg-wow-back">
	<div class="container">
		<div class="row align-items-center justify-content-center no-gutters min-vh-100">
			<div class="col-12 col-md-8 col-lg-5">

				<div class="card p-4">

					<form action="/admin/login/login.php" method="post" autocomplete="off">

						<div class="text-left">
							<h2 class="h2">Log In</h2>
						</div>

						<?php if (isset($_GET['status']) && $_GET['status'] == '500') : ?>
						<div class="alert alert-danger">Dados incorretos</div>
						<?php endif; ?>

						<div class="form-group">
							<label class="small text-muted font-weight-bold mb-1" for="email">
								Email
							</label>
							<input type="email" class="form-control" name="email" id="email" required>
						</div>

						<div class="form-group">
							<label class="small text-muted font-weight-bold mb-1" for="password">
								Senha
							</label>
							<input type="password" class="form-control" name="password" required>
						</div>

						<button class="btn btn-block btn-primary" type="submit">Entrar</button>

					</form>

				</div>

			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end container -->
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/_footer.php'); ?>