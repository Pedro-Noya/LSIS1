<?php
require_once 'BLL/Login_Utilizador_BLL.php';
require_once 'BLL/Logger_BLL.php';

session_start();

$mensagemErro = '';

function login($email, $bll) {
  $_SESSION['email'] = $email;
  $_SESSION['papel'] = $bll->obterPapelPorEmail($email);
  $_SESSION['logged_in'] = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bll = new Login_Utilizador_BLL();
    $loggerBLL = new LoggerBLL();
    $resultado = $bll->autenticarUtilizador($_POST['email'], $_POST['password']);

    if ($resultado === 'ativo') {
      login($_POST['email'], $bll);
      $loggerBLL->registarLog($_POST['email'], "Login efetuado com sucesso");
      header("Location: index.php");
      exit();
    } else if ($resultado === 'inativo') {
      login($_POST['email'], $bll);
      $loggerBLL->registarLog($_POST['email'], "Login efetuado com sucesso");
      header("Location: perfil.php"); 
      exit();
    } else {
      $mensagemErro = $resultado;
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Portal do Colaborador - Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/login.css">
</head>
<body>
  <?php include "cabecalho.php"; ?>
    <div class="titulo-pagina">
        <h1>Login</h1>
    </div>
  <br/>

  <div class="container">
    <?php if (!empty($mensagemErro)): ?>
      <div class="erro"><?= htmlspecialchars($mensagemErro) ?></div>
    <?php endif; ?>

    <form method="POST">
      <input id="emailInput" type="text" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Palavra-Passe" required><br>
      <div id="capsLockSpacing"></div>
      <div id="capsLockWarning">
        Caps-Lock Ativo
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
  <script src="js/capsLockWarning.js"></script>
  <script src="js/login.js"></script>
</body>
</html>
