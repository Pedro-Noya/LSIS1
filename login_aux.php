<?php
// portal.php
include "login_bll.php";
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Portal do Colaborador - Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
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

        <!-- Botão branco com sino + texto -->
        <div class="pedido-demo-box">
          <span>🔔</span>
          <span>Pedir uma demo</span>
        </div>

        <!-- Botão azul escuro -->
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
    <?php showUI(); ?>
    <div class="link">
      <a href="forgot.php">Esqueci-me da palavra-passe</a> |
      <a href="register.php">Não tem conta? Registar</a>
    </div>
  </div>

</body>
</html>