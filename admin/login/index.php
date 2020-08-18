<?php
$_header = $_SERVER['DOCUMENT_ROOT'] . '/admin/_header.php';
include($_header);
?>

<main>
  <div class="container">
    <div class="row align-items-center justify-content-center no-gutters min-vh-100">
      <div class="col-12 col-md-5 col-lg-4 py-5">

        <form class="mb-4">

          <div class="form-group">
            <label class="small text-muted text-uppercase font-weight-bold mb-1" for="email">
              Email
            </label>
            <input type="email" class="form-control" id="email">
          </div>

          <div class="form-group">
            <label class="small text-muted text-uppercase font-weight-bold mb-1" for="password">
              Senha
            </label>
            <input type="password" class="form-control" id="password">
          </div>

          <p class="text-right">
            <a href="./password-reset.php">Esqueceu sua senha?</a>
          </p>

          <button class="btn btn-block btn-primary" type="submit">Entrar</button>
          
        </form>

      </div><!-- end col -->
    </div><!-- end row -->
  </div><!-- end container -->
</main>

<?php
$_footer = $_SERVER['DOCUMENT_ROOT'] . '/admin/_footer.php';
include($_footer);
?>