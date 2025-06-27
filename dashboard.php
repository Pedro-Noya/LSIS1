<?php
// dashboard.php

  session_start();
  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
      header("Location: login.php");
      exit();
  }

  // no-cache headers to prevent the browser from showing a cached page after logout
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");

?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Portal do Colaborador - Dashboard</title>
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
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-radius: 20px;
    }

    .topbar .logo {
      font-size: 24px;
      font-weight: bold;
    }

    nav {
      display: flex;
      gap: 20px;
      align-items: center;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: 500;
    }

    .btn-demo {
      background: white;
      color: #0767ea;
      padding: 5px 15px;
      border-radius: 20px;
      text-decoration: none;
      font-weight: 600;
    }

    .btn-experiment {
      background: #1a3760;
      color: white;
      padding: 5px 15px;
      border-radius: 20px;
      text-decoration: none;
      font-weight: 600;
    }

    h1 {
      text-align: center;
      margin: 20px 0 10px;
      color: white;
      font-weight: 400;
    }

    .tabs {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 30px;
    }

    .tabs div {
      padding: 10px 20px;
      border-radius: 12px;
      background: #f4f4f4;
      color: #1a3760;
      font-weight: bold;
    }

    .tabs .active {
      background: #1a3760;
      color: white;
    }

    .content {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      margin: 40px auto;
      max-width: 1000px;
    }

    .box {
      border: 2px solid #2a9df3;
      border-radius: 20px;
      padding: 20px;
      flex: 1 1 400px;
      text-align: center;
    }

    .box h2 {
      color: #2a9df3;
      font-weight: 500;
      margin-bottom: 20px;
    }

    .stats {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-bottom: 20px;
    }

    .stats div {
      color: #2a9df3;
      font-size: 20px;
    }

    .charts {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .charts img {
      width: 180px;
      height: auto;
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <div class="topbar">
    <div class="logo">tlantic</div>
    <nav>
      <a href="#">sobre nós</a>
      <a href="#">soluções</a>
      <a href="#">setores</a>
      <a href="#">recursos</a>
      <a href="#">Pesquisar 🔍</a>
      <a href="#" class="btn-demo">🔔 Pedir uma demo</a>
      <a href="#" class="btn-experiment">Experimente agora</a>
      <a href="#">PT ▾</a>
    </nav>
  </div>

  <h1>Portal do Colaborador</h1>

  <div class="tabs">
    <div class="active">Dashboard</div>
    <div>Info Pessoal</div>
    <div>Benefícios</div>
    <div>Férias</div>
    <div>Formações</div>
  </div>

  <div class="content">
    <div class="box">
      <h2>Demográficas Naturais</h2>
      <div class="stats">
        <div><strong>33</strong><br>Idade Média</div>
        <div><strong>2,5</strong><br>Média de Anos<br>na tlantic</div>
        <div><strong>41</strong><br>% De colab.<br>do sexo feminino</div>
      </div>
      <div class="charts">
        <img src="https://via.placeholder.com/180x180?text=Gráfico+1" alt="Demográficas 1">
      </div>
    </div>

    <?php if ($_SESSION['logged_in']): ?>
      <div class="link">
        Bem-vindo, <?= htmlspecialchars($_SESSION['papel']) ?>!
        <a href="logout.php">Sair</a>
      </div>
    <?php endif; ?>

    <div class="box">
      <h2>Demográficas Empresariais</h2>
      <div class="stats">
        <div><strong>95</strong><br>Taxa de Retenção</div>
        <div><strong>2,5</strong><br>Remuneração Média</div>
      </div>
      <div class="charts">
        <div>
          <span style="color:#2a9df3; font-weight: 600;">Dist. Por Função</span><br>
          <img src="https://via.placeholder.com/180x180?text=Função" alt="Função">
        </div>
        <div>
          <span style="color:#2a9df3; font-weight: 600;">Dist. Por Hierarquia</span><br>
          <img src="https://via.placeholder.com/180x180?text=Hierarquia" alt="Hierarquia">
        </div>
      </div>
    </div>
  </div>
</body>
</html>