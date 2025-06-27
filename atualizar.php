<?php
require_once 'BLL/Registo_Utilizador_BLL.php';

session_start();

$mensagemErro = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nome_completo = $_POST['nome_completo'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $confirmPassword = $_POST['confirmPassword'] ?? '';
  $role = $_POST['role'] ?? '';
  $sexo = $_POST['sexo'] ?? '';
  $nacionalidade = $_POST['nacionalidade'] ?? '';
  $dataNascimento = $_POST['dataNascimento'] ?? '';

  $bll = new Registo_Utilizador_BLL();
  $resultado = $bll->registarUtilizador(
    $nome_completo,
    $email,
    $password,
    $confirmPassword,
    $role,
    $sexo,
    $nacionalidade,
    $dataNascimento
  );

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

  <div class="section-title">Atualizar Informações (Colaborador)</div>

  <div class="container">
    <form method="POST" action="">
        <input type="email" name="email" value="email@gmail.com" disabled /><br />
        <input type="text" name="nome_completo" placeholder="Nome Completo" value="<?= htmlspecialchars($_GET['nome'] ?? '') ?>" required /><br />
        <input type="password" name="password" placeholder="Palavra-Passe" required /><br />
        <input type="password" name="confirmPassword" placeholder="Confirmar Palavra-Passe" required /><br />
        <div id="capsLockSpacing" style="height: 16px;"></div>
        <div id="capsLockWarning">
            Caps-Lock Ativo
        </div><br/>

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" value ="<?= htmlspecialchars($_GET['sexo'] ?? '') ?>" required>
          <option value="" disabled>Sexo</option>
          <option value="Masculino">Masculino</option>
          <option value="Feminino">Feminino</option>
        </select><br />

        <input type="text" name="nacionalidade" placeholder="Nacionalidade" value="<?= htmlspecialchars($_GET['nacionalidade'] ?? '') ?>"/><br />
        <br />

        <label for="dataNascimento">Data de Nascimento:</label>
        <input type="date" id="dataNascimento" name="dataNascimento"/><br />
      <br />
      <button type="submit">Atualizar</button>
    </form>

    <?php if (!empty($mensagemErro)): ?>
      <div class="erro"><?= htmlspecialchars($mensagemErro) ?></div>
    <?php endif; ?>
  </div>
  <script src="JS/capsLockWarning.js"></script>
</body>
</html>
