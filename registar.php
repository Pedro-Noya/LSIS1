<?php
require_once 'BLL/Registo_Utilizador_BLL.php';
require_once 'BLL/Logger_BLL.php';
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([3]);

function generateRandomPassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
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
    $loggerBLL = new LoggerBLL();
    $loggerBLL->registarLog(
      $_SESSION['email'],
      "Registou um novo colaborador: $nome",
      "Email Pessoal: $emailPessoal\nEmail: $email"
    );
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
  <link rel="stylesheet" href="CSS/registar.css" />
</head>
<body>

  <?php include "cabecalho.php"; ?>

  <div class="section-title">Registar Utilizador no Portal</div>
  <br/>

  <?php if (!empty($mensagemErro)): ?>
    <div class="erro"><?= htmlspecialchars($mensagemErro) ?></div>
  <?php endif; ?>

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

  </div>
  <script src="JS/capsLockWarning.js"></script>
</body>
</html>
