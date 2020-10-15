<?php
$_header = './_header.php';
include($_header);
?>

<main class="bg-wow-back1">
  <div class="container">
    <div class="row align-items-center justify-content-center no-gutters min-vh-100">
      <div class="col-12 col-md-5 col-lg-5">

        <div class="card p-4">
          <form action="pessoal.php" method="post" class="mb-4" autocomplete="off">

              <div class="text-left">
                  <h2 class="h2">Primeiros passos</h2>
                  <p class="text-muted">Informe seus CPF para continuar.</p>
              </div>

              <div class="form-group">
                  <label class="small text-muted text-uppercase font-weight-bold mb-1" for="cpf">
                  CPF
                  </label>
                  <input type="text" class="form-control" name="cpf" id="cpf" required>
              </div>

              <button class="btn btn-block btn-primary" type="submit">Continuar</button>
            
          </form>

          <p class="text-center">
            Já tem cadastro? <a href="/login.php">entrar</a>.
          </p>
        </div>

      </div><!-- end col -->
    </div><!-- end row -->
  </div><!-- end container -->
</main>

<?php
$_footer = './_footer.php';
include($_footer);
?>