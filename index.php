<?php
$_header = '_header.php';
include($_header);

if (!$_SESSION) {
  header("location: /login.php");
  exit();
}

?>

<main>
  <div class="container">
    <h1 class="text-primary mt-5">Página inicial</h1>
    <code><?php echo ($_SESSION['empresa']) ?: 'Erro'; ?></code>
    <a href="/logout.php">logout</a>
  </div>
</main>

<?php
$_footer = '_footer.php';
include($_footer);
?>