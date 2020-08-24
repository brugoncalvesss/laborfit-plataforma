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

	<div class="container">

        <div class="card mb-3">
            <div class="card-body">
                <code>Vídeo</code>
            </div>
        </div>

	</div>
</main>

<?php
$_footer = '_footer.php';
include($_footer);
?>