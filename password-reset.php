<?php require('_header.php'); ?>

<main>
  <div class="container">
    <div class="row align-items-center justify-content-center no-gutters min-vh-100">
      <div class="col-12 col-md-5 col-lg-4 py-5">

        <form action="enviarEmail.php" method="post" class="mb-4" autocomplete="off">

          <div class="text-left">
            <h2 class="h2">Esqueceu a senha?</h2>
            <p class="text-muted">Informe seu e-mail para resetar sua senha.</p>
          </div>

          <div class="form-group">
            <label class="small text-muted text-uppercase font-weight-bold mb-1">
              CPF
            </label>
            <input type="text" class="form-control" id="cpf" name="CPF_USUARIO" required>
          </div>

          <button class="btn btn-block btn-primary" type="submit">Recuperar</button>
          
        </form>

        <p class="text-center">
          Já tem cadastro? <a href="/login.php">entrar</a>.
        </p>

      </div><!-- end col -->
    </div><!-- end row -->
  </div><!-- end container -->
</main>

<?php require('_footer.php'); ?>