<?php
// login.php
require_once 'BLL/Login_Utilizador_BLL.php';

session_start();

$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bll = new Login_Utilizador_BLL();
    $resultado = $bll->autenticarUtilizador($_POST['email'], $_POST['password']);

    if ($resultado === true) {
        header("Location: area_utilizador.php"); // Redireciona após login bem-sucedido
        exit();
    } else {
        $mensagemErro = $resultado; // Mensagem de erro da BLL
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
      <input type="text" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Palavra-Passe" required><br>
      <div id="capsLockSpacing"></div>
      <div id="capsLockWarning">
        Caps-Lock Ativo
      </div>
      <button type="submit">Login</button>
    </form>

    <div class="link">
      <a href="forgot.php">Esqueci-me da palavra-passe</a> |
      <a href="registar.php">Não tem conta? Registar</a>
    </div>
  </div>
  <script src="js/capsLockWarning.js"></script>
</body>
</html>
