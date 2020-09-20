<?php require('_header.php'); ?>

<main>
  <div class="container">
    <div class="row align-items-center justify-content-center no-gutters min-vh-100">
      <div class="col-12 col-md-5 col-lg-4 py-5">

        <form action="atualizarUsuario.php" method="post" class="mb-4" autocomplete="off">

          <div class="text-left">
            <h2 class="h2">Recuperação de senha</h2>
            <p class="text-muted">Informe a nova senha de acesso.</p>
          </div>

          <?php 
          $hash = $_GET['q'] ?: null;
          $hash = base64_decode(substr($hash, 4));
          ?>

            <?php if (!empty($hash)) : ?>
                <input type="hidden" name="CPF_USUARIO" value="<?= $hash; ?>">
            <div class="form-group">
                <label class="small text-muted text-uppercase font-weight-bold mb-1">
                Senha
                </label>
                <input type="password" class="form-control" name="SENHA_USUARIO">
            </div>

            <button class="btn btn-block btn-primary" type="submit">Atualizar</button>

            <?php else: ?>
            <p>Seu link expirou, tente novamente.</p>
            <?php endif; ?>
          
        </form>

      </div><!-- end col -->
    </div><!-- end row -->
  </div><!-- end container -->
</main>

<?php require('_footer.php'); ?>