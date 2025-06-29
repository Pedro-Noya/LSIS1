<?php
require_once 'BLL/Login_Utilizador_BLL.php';

session_start();

$mensagemErro = '';

function login($email, $bll) {
  $_SESSION['email'] = $email;
  $_SESSION['papel'] = $bll->obterPapelPorEmail($email);
  $_SESSION['logged_in'] = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bll = new Login_Utilizador_BLL();
    $resultado = $bll->autenticarUtilizador($_POST['email'], $_POST['password']);

    if ($resultado === 'ativo') {
      login($_POST['email'], $bll);
      header("Location: dashboard.php");
      exit();
    } else if ($resultado === 'inativo') {
      login($_POST['email'], $bll);
      header("Location: atualizar_perfil.php"); 
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
  <link rel="stylesheet" href="CSS/global.css" />
  <link rel="stylesheet" href="CSS/login.css">
</head>
<body>

  <!-- Cabeçalho completo -->
  <div class="topbar">
    <div class="topnav">
      <div class="logo">tlantic</div>
      <nav>
        <a href="#">sobre nós</a>
        <a href="#">soluções</a>
        <a href="#">setores</a>
        <a href="#">recursos</a>
        <a href="#">Pesquisar 🔍</a>
        <div class="pedido-demo-box">
          <span>🔔</span>
          <span>Pedir uma demo</span>
        </div>
        <a href="#" class="btn-experiment">Experimente agora</a>
        <a href="#">PT ▾</a>
      </nav>
    </div>
    <h1>Portal do Colaborador</h1>
  </div>

  <!-- Subtítulo -->
  <div class="section-title">Login | Entrar no seu Portal</div>

  <!-- Formulário -->
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

    <div class="link">
      <a href="passReset.php">Esqueci-me da palavra-passe</a>
    </div>
  </div>
  <script src="js/capsLockWarning.js"></script>
  <script src="js/login.js"></script>
</body>
</html>
