<?php
$_header = '_header.php';
include($_header);

if (!$_SESSION) {
	header("location: /login.php");
	exit();
}
?>

<main>
	<nav class="nav py-3 bg-dark text-light mb-4">
		<div class="container">
			<div class="d-flex justify-content-between">
				<div><code>Página inicial</code></div>
				<div><a href="/logout.php">logout</a></div>
			</div>
		</div>
	</nav>

	<div class="container mb-5">
		
		<div class="row">
			<div class="col-12 col-md-10 offset-md-1">

				<div class="card mb-3">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0&modestbranding=1" allowfullscreen></iframe>
					</div>
					<div class="card-body">
						<h5 class="card-title text-center text-primary">
							Nome do vídeo
						</h5>
					</div>
				</div>
		
			</div>
		</div>

	</div>
</main>

<?php
$_footer = '_footer.php';
include($_footer);
?>