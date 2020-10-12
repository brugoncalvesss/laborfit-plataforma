<?php require('_header.php'); ?>

<main>
  <div class="container">
    <div class="row align-items-center justify-content-center no-gutters min-vh-100">
      <div class="col-12 col-md-5 col-lg-4 py-5">

        <form action="logarUsuario.php" method="post" class="mb-4" autocomplete="off">

          <div class="text-left">
            <h2 class="h2">Log In</h2>
            <p class="text-muted">Informe seus dados para entrar.</p>
          </div>

          <?php if (isset($_GET['status']) && $_GET['status'] == '500') : ?>
          <div class="alert alert-danger">Senha incorreta.</div>
          <?php endif; ?>

          <div class="form-group">
            <label class="small text-muted text-uppercase font-weight-bold mb-1" for="cpf">
              CPF
            </label>
            <input type="text" class="form-control" name="cpf" id="cpf">
          </div>

          <div class="form-group">
            <label class="small text-muted text-uppercase font-weight-bold mb-1" for="password">
              Senha
            </label>
            <input type="password" class="form-control" name="password" id="password">
          </div>

          <p class="text-right">
            <a href="/password-reset.php">Esqueceu sua senha?</a>
          </p>

          <button class="btn btn-block btn-primary" type="submit">Entrar</button>
          
        </form>

        <p class="text-center">
          Primeiro acesso? <a href="/acesso.php">cadastre-se</a>.
        </p>

      </div><!-- end col -->
    </div><!-- end row -->
  </div><!-- end container -->
</main>

<?php require('_footer.php'); ?>