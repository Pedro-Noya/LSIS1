<?php
// formacoes.php
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Portal do Colaborador - Formações</title>
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

    .tabs {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 20px;
    }

    .tabs div {
      padding: 10px 20px;
      border-radius: 10px;
      background: #f4f4f4;
      color: #1a3760;
      font-weight: bold;
    }

    .tabs .active {
      background: #1a3760;
      color: white;
    }

    .filtros {
      margin: 30px;
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .filtros div {
      background: #2a9df3;
      color: white;
      padding: 8px 20px;
      border-radius: 8px;
      font-weight: bold;
    }

    .formacoes-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      margin-bottom: 60px;
    }

    .formacao-box {
      border: 2px solid #2a9df3;
      border-radius: 15px;
      padding: 15px;
      width: 250px;
      text-align: center;
      margin: 10px;
    }

    .formacao-box h3 {
      color: #2a9df3;
      margin-bottom: 10px;
    }

    .formacao-box img {
      width: 80%;
      height: auto;
      border-radius: 10px;
      margin-bottom: 10px;
    }

    .formacao-box p {
      font-size: 14px;
      color: #2a9df3;
      margin-bottom: 10px;
    }

    .formacao-box a {
      color: #2a9df3;
      font-weight: bold;
      text-decoration: none;
    }
  </style>
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

  <div class="tabs">
    <div>Info Pessoal</div>
    <div>Benefícios</div>
    <div>Férias</div>
    <div class="active">Formações</div>
  </div>

  <div class="filtros">
    <div>Nível de Ensino: |</div>
    <div>Duração: |</div>
    <div>Horário: | Diurno</div>
    <div>Raio: | 1-100 km</div>
  </div>

  <div class="formacoes-container">
    <?php
    $formacoes = [
      [
        'titulo' => 'MBA Gestão de Projetos',
        'imagem' => 'https://via.placeholder.com/200x120?text=MBA',
        'nivel' => 7,
        'duracao' => '2 anos',
        'local' => 'Porto Business School',
        'horario' => 'Diurno'
      ],
      [
        'titulo' => 'Curso Primeiros Socorros',
        'imagem' => 'https://via.placeholder.com/200x120?text=Socorros',
        'nivel' => 4,
        'duracao' => '40h',
        'local' => 'ESE (Porto)',
        'horario' => 'Diurno'
      ],
      [
        'titulo' => 'MBA Gestão de Projetos',
        'imagem' => 'https://via.placeholder.com/200x120?text=MBA',
        'nivel' => 7,
        'duracao' => '2 anos',
        'local' => 'UMinho',
        'horario' => 'Diurno'
      ],
    ];

    foreach ($formacoes as $f) {
      echo '<div class="formacao-box">';
      echo '<h3>' . htmlspecialchars($f['titulo']) . '</h3>';
      echo '<img src="' . htmlspecialchars($f['imagem']) . '" alt="' . htmlspecialchars($f['titulo']) . '">';
      echo '<p>Nível de Formação: ' . $f['nivel'] . '<br>';
      echo 'Duração: ' . $f['duracao'] . '<br>';
      echo $f['local'] . '<br>';
      echo 'Horário: ' . $f['horario'] . '</p>';
      echo '<a href="#">Ver Mais</a>';
      echo '</div>';
    }
    ?>
  </div>
</body>
</html>