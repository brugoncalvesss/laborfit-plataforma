<?php
$_header = './_header.php';
include($_header);

$cpf = limparCaracteres($_POST['cpf']) ?: null;

if (empty($cpf)) {
		die("Informe seu cpf.");
}

$PDO = db_connect();

$sql = "SELECT CPF_USUARIO FROM USUARIOS WHERE CPF_USUARIO = :CPF_USUARIO";

$request = $PDO->prepare($sql);
$request->bindParam(':CPF_USUARIO', $cpf);
$request->execute();
$usuario = $request->fetch(PDO::FETCH_ASSOC);

?>

<main>
	<div class="container">
		<div class="row align-items-center justify-content-center no-gutters min-vh-100">
			<div class="col-12 col-md-5 col-lg-4 py-5">

				<?php if ($usuario > 0) : ?>
				<form action="cadastrarUsuario.php" method="post" class="mb-4" autocomplete="off">

					<div class="text-left">
						<h2 class="h2">Dados pessoais</h2>
						<p class="text-muted">Complete seu cadastro para entrar.</p>
					</div>

					<input type="hidden" name="cpf" value="<?= $usuario['CPF_USUARIO'] ?>">

					<div class="form-group">
						<label class="small text-muted text-uppercase font-weight-bold mb-1">Como gostaria de ser chamado(a)?</label>
						<input type="text" name="APELIDO_USUARIO" class="form-control" required>
					</div>

					<div class="form-group">
						<label class="small text-muted text-uppercase font-weight-bold mb-1">Data de nascimento</label>
						<input type="text" name="nascimento" class="form-control" id="data">
					</div>

					<div class="form-group">
						<label class="small text-muted text-uppercase font-weight-bold mb-1">Sexo</label>
						<select name="SEXO_USUARIO" class="form-control">
							<option value="ND">Selecione</option>
							<option value="Feminino">Feminino</option>
							<option value="Masculino">Masculino</option>
							<option value="Não Definido">Não Definido</option>
						</select>
					</div>

					<div class="form-group">
						<label class="small text-muted text-uppercase font-weight-bold mb-1">E-mail</label>
						<input type="email" class="form-control" name="email" required>
					</div>

					<div class="form-group">
						<label class="small text-muted text-uppercase font-weight-bold mb-1">Senha</label>
						<input type="password" class="form-control" name="password" minlength="6" required>
					</div>

					<button class="btn btn-block btn-primary" type="submit">Cadastrar</button>
					
				</form>
				<?php else : ?>
				<div class="text-left">
						<h2 class="h4">Não encontramos seu cadastro</h2>
						<p class="text-muted">Quer tentar novamente? <a href="/acesso.php">clique aqui</a>.</p>
				</div>
				<?php endif; ?>
				
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end container -->
</main>


<?php
$_footer = './_footer.php';
include($_footer);
?>