<?php
// login.php
require_once 'Login_Utilizador_BLL.php';

session_start();

$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bll = new Login_Utilizador_BLL();
    $resultado = $bll->autenticarUtilizador($_POST['username'], $_POST['password']);

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
  <style>
    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background-color: #ffffff;
    }

    .topbar {
      background: linear-gradient(to right, #0767ea, #2a9df3);
      color: white;
      padding: 20px 40px 40px 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      border-radius: 20px;
    }

    .topnav {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
    }

    nav {
      display: flex;
      gap: 20px;
      align-items: center;
      flex-wrap: wrap;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: 500;
    }

    .btn-experiment {
      background: #1a3760;
      color: white;
      padding: 6px 15px;
      border-radius: 20px;
      font-weight: 600;
      text-decoration: none;
    }

    .pedido-demo-box {
      background: white;
      border-radius: 20px;
      padding: 5px 12px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .pedido-demo-box span {
      color: #0767ea;
      font-weight: 600;
    }

    .topbar h1 {
      margin-top: 20px;
      font-weight: normal;
      font-size: 26px;
    }

    .section-title {
      text-align: center;
      font-size: 22px;
      color: #2a9df3;
      font-weight: 500;
      margin-top: 30px;
    }

    .container {
      margin: 30px auto 60px auto;
      max-width: 400px;
      padding: 30px;
      border: 1px solid #2a9df3;
      border-radius: 15px;
      text-align: center;
    }

    .container h2 {
      color: #1a3760;
      margin-bottom: 5px;
    }

    input[type="text"], input[type="password"] {
      width: 90%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #39a4f3;
      border-radius: 8px;
      font-size: 14px;
      outline: none;
    }

    button {
      background-color: #39a4f3;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
      margin-top: 15px;
    }

    .link {
      margin-top: 15px;
      font-size: 13px;
    }

    .link a {
      color: #39a4f3;
      text-decoration: none;
    }

    .erro {
      color: red;
      font-size: 14px;
      margin-top: 10px;
    }
  </style>
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
      <input type="text" name="username" placeholder="Nome de Utilizador" required><br>
      <input type="password" name="password" placeholder="Palavra-Passe" required><br>
      <div style="font-size: 12px; color: grey;">Caps-Lock Ativo</div>
      <button type="submit">Login</button>
    </form>

    <div class="link">
      <a href="forgot.php">Esqueci-me da palavra-passe</a> |
      <a href="atualizar.php">Não tem conta? Registar</a>
    </div>
  </div>

</body>
</html>
