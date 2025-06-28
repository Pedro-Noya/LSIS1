<?php
require_once 'BLL/Registo_Utilizador_BLL.php';

session_start();

function generateRandomPassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+[]{}|;:,.<>?';
    $password = '';
    $maxIndex = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $maxIndex)];
    }
    return $password;
}

$mensagemErro = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nome = $_POST['nome'] ?? 'Colaborador(a)';
  $emailPessoal = $_POST['emailPessoal'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = generateRandomPassword();


  $bll = new Registo_Utilizador_BLL();
  $resultado = $bll->registarUtilizador(
    $emailPessoal,
    $nome,
    $email,
    $password
  );

  if ($resultado === true) {
    /*header("Location: login.php");
    exit();*/
  } else {
    $mensagemErro = $resultado;
  }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <title>Portal do Colaborador - Registo</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="CSS/global.css" />
  <link rel="stylesheet" href="CSS/registar.css" />
</head>
<body>
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

  <div class="section-title">Registar Utilizador no Portal</div>

  <div class="container">
    <form method="POST" action="">
      <input type="text" name="nome" placeholder="Nome" required /><br />
      <input type="email" name="emailPessoal" placeholder="Email Pessoal" required /><br />
      <input type="email" name="email" placeholder="Email" required /><br />
      <div id="capsLockSpacing" style="height: 16px;"></div>
      <div id="capsLockWarning">
        Caps-Lock Ativo
      </div><br/>

      <button type="submit">Registar</button>
    </form>

    <?php if (!empty($mensagemErro)): ?>
      <div class="erro"><?= htmlspecialchars($mensagemErro) ?></div>
    <?php endif; ?>
  </div>
  <script src="JS/capsLockWarning.js"></script>
</body>
</html>
