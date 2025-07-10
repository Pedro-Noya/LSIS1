<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || ($_SESSION['papel'] != 3 && $_SESSION['papel'] != 4)) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Criar Nova Formação</title>
  <link rel="stylesheet" href="CSS/formacoes.css">
</head>
<body>
  <?php include "cabecalho.php"; ?>

  <div class="formulario-container">
    <h2>➕ Nova Formação</h2>
    <form method="POST" action="API/inserir_formacao.php" enctype="multipart/form-data">
    <label>Título:</label>
    <input type="text" name="titulo" required>

    <label>Descrição:</label>
    <textarea name="descricao" rows="5" required></textarea>

    <label>Imagem:</label>
    <input type="file" name="imagem" accept="image/*" required>

    <label>Nível de Ensino:</label>
    <input type="number" name="nivelEnsino" min="1" max="8" required>

    <label>Duração (em horas):</label>
    <input type="number" name="duracao" min="1" required placeholder="ex: 40">

    <label>Localização:</label>
    <input type="text" name="localizacao" required>

    <label>Horário:</label>
    <select name="horario" required>
        <option value="Diurno">Diurno</option>
        <option value="Pós-laboral">Pós-laboral</option>
        <option value="Online">Online</option>
    </select>

    <button type="submit">Guardar Formação</button>
    </form>
  </div>
</body>
</html>
