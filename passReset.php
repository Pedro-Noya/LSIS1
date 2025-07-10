<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Esqueci-me da Palavra-Passe</title>
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
      margin: 40px 0 10px;
      color: #2a9df3;
      font-weight: 500;
    }

    .container {
      max-width: 400px;
      margin: auto;
      padding: 30px;
      border: 2px solid #2a9df3;
      border-radius: 15px;
      text-align: center;
      color: #2a9df3;
    }

    input[type="email"] {
      width: 90%;
      padding: 10px;
      margin-top: 20px;
      border: 1px solid #39a4f3;
      border-radius: 5px;
      font-size: 14px;
    }

    button {
      margin-top: 20px;
      background-color: #39a4f3;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
    }
  </style>
</head>
<body>
  <?php include "cabecalho.php"; ?>
  <h1>Esqueci-me da Palavra Passe</h1>

  <div class="container">
    <p>Insira o email com que criou a conta.<br>
    Um email será enviado para o seu endereço com um código para<br>
    recuperar a sua conta.</p>

    <form method="POST" action="#">
      <input type="email" name="email" placeholder="Email" required>
      <button type="submit">Enviar</button>
    </form>
  </div>
</body>
</html>