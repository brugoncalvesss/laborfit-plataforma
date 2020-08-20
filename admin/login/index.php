<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/_header.php'); ?>

<main class="bg-light">
  <div class="container">
    <div class="row align-items-center justify-content-center no-gutters min-vh-100">
      <div class="col-12 col-md-8 col-lg-5">

        <form class="p-5 bg-white rounded shadow-sm mb-4">

          <h4 class="mb-3">Login</h4>

          <div class="form-group">
            <label class="small text-muted font-weight-bold mb-1" for="email">
              Email
            </label>
            <input type="email" class="form-control" id="email">
          </div>

          <div class="form-group">
            <label class="small text-muted font-weight-bold mb-1" for="password">
              Senha
            </label>
            <input type="password" class="form-control" id="password">
          </div>

          <p class="text-right">
            <a class="btn btn-link" href="#./password-reset.php">Esqueceu sua senha?</a>
          </p>

          <button class="btn btn-block btn-primary" type="submit">Entrar</button>
          
        </form>

        <p class="text-center">
          <a class="btn btn-warning" href="/admin/login/login.php">Clique aqui para entrar</a>
        </p>

      </div><!-- end col -->
    </div><!-- end row -->
  </div><!-- end container -->
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/_footer.php'); ?>