<?php
require_once '../BLL/Equipas_BLL.php';
require_once '../BLL/Logger_BLL.php';
require_once __DIR__ . "/../verificar_acesso.php";
verificarAcesso([3]);

$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeEquipa = $_POST['nomeEquipa'] ?? '';
    $dataCriacao = $_POST['dataCriacao'] ?? date('Y-m-d');

    $bll = new Equipa_BLL();
    $resultado = $bll->registarEquipa($nomeEquipa, $dataCriacao);

    if ($resultado === true) {
        $loggerBLL = new LoggerBLL();
        $loggerBLL->registarLog(
            $_SESSION['email'],
            "Registou uma nova equipa: $nomeEquipa",
            "Localização: $localizacao\nData de Criação: $dataCriacao"
        );
        header("Location: equipasElementos.php");
        exit();
    } else {
        $mensagemErro = $resultado;
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

    <div class="titulo-pagina">
        <h1>Criar Equipa</h1>
    </div>

    <br/>

    <div class="container">
        <?php if (!empty($mensagemErro)): ?>
            <div class="erro"><?= htmlspecialchars($mensagemErro) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <label for="nomeEquipa">Nome da Equipa:</label>
            <input type="text" id="nomeEquipa" name="nomeEquipa" required>

            <label for="dataCriacao">Data de Criação:</label>
            <input type="date" id="dataCriacao" name="dataCriacao" value="<?= date('Y-m-d') ?>">

            <button type="submit">Registar Equipa</button>
        </form>
    </div>
</body>
</html> 