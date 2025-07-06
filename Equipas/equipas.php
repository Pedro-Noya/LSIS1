<?php
require_once '../BLL/Equipas_BLL.php';


session_start();

$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeEquipa = $_POST['nomeEquipa'] ?? '';
    $localizacao = $_POST['localizacao'] ?? '';
    $dataCriacao = $_POST['dataCriacao'] ?? date('Y-m-d');

    $bll = new Equipa_BLL();
    $resultado = $bll->registarEquipa($nomeEquipa, $localizacao, $dataCriacao);

    if ($resultado === true) {
        header("Location: equipasElementos.php"); // Redireciona após registo bem-sucedido
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
    <title>Portal do Colaborador - Registo de Equipa</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/equipas.css">
</head>
<body>
    <?php include "../cabecalho.php"; ?>

    <div class="section-title">Registo de Equipa</div>

    <div class="container">
        <?php if (!empty($mensagemErro)): ?>
            <div class="erro"><?= htmlspecialchars($mensagemErro) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <label for="nomeEquipa">Nome da Equipa:</label>
            <input type="text" id="nomeEquipa" name="nomeEquipa" required>

            <label for="localizacao">Localização:</label>
            <input type="text" id="localizacao" name="localizacao" required>

            <label for="dataCriacao">Data de Criação:</label>
            <input type="date" id="dataCriacao" name="dataCriacao" value="<?= date('Y-m-d') ?>">

            <button type="submit">Registar Equipa</button>
        </form>
    </div>
</body>
</html> 