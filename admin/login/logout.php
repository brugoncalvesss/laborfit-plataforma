<?php
setcookie("LEMBRAR_USUARIO", false, time() - 1);
unset($_COOKIE['USUARIO_EMPRESA']);
unset($_COOKIE['USUARIO_NOME']);
header("location: /admin/login/");
exit();