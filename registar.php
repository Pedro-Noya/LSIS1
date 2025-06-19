<?php
require_once 'BLL/Registo_Utilizador_BLL.php';

$mensagemErro = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    $bll = new Registo_Utilizador_BLL();
    $resultado = $bll->registarUtilizador($username, $email, $password, $confirm);

    if ($resultado === true) {
        header("Location: login.php");
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
  <title>Portal do Colaborador - Registo</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/registar.css">
</head>
<body>

  <!-- Cabeçalho -->
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
  <div class="section-title">Registar-se no Portal</div>

  <!-- Formulário -->
  <div class="container">
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Nome de Utilizador" required><br>
      <input type="password" name="password" placeholder="Palavra-Passe" required><br>
      <input type="password" name="confirm" placeholder="Confirmar Palavra-Passe" required><br>
      <input type="email" name="email" placeholder="Email" required><br>
      <button type="submit">Registar/Atualizar Informação</button>
    </form>
    <?php if (!empty($mensagemErro)): ?>
      <div class="erro"><?= htmlspecialchars($mensagemErro) ?></div>
    <?php endif; ?>
  </div>

</body>
</html>
