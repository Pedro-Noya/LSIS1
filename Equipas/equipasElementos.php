<?php
require_once '../BLL/Equipas_Elementos_BLL.php';
require_once '../BLL/Global_BLL.php';
require_once '../BLL/Logger_BLL.php';
require_once __DIR__ . "/../verificar_acesso.php";
verificarAcesso([3]);

$mensagemErro = '';

$globalbll = new Global_BLL();
$equipas = $globalbll->getEquipas();
$elementos = $globalbll->getUtilizadores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeEquipa = $_POST['nomeEquipa'] ?? '';
    $emailElemento = $_POST['Elemento'] ?? '';
    $acao = $_POST['acao'] ?? '';

    $bll = new Equipas_Elementos_BLL();
    $loggerBLL = new LoggerBLL();
    if ($acao === 'remover') {
        $resultado = $bll->removerElementoEquipa($nomeEquipa, $emailElemento);
    } else {
        if (empty($nomeEquipa) || empty($emailElemento)) {
            $mensagemErro = "Por favor, preencha todos os campos.";
            return;
        }
        
        $permitir=$bll->permitirAdicionar($nomeEquipa, $emailElemento);
        if(!$permitir){
            return;
        }
        $resultado = $bll->adicionarElementoEquipa($nomeEquipa, $emailElemento);
        
    }

    if ($resultado === true) {
        $loggerBLL->registarLog(
            $_SESSION['email'],
            "Executou a ação '$acao elemento' na equipa: $nomeEquipa",
            "Elemento: $emailElemento"
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
        <h1>Editar Equipas</h1>
    </div>

    <br/>

    <div class="container">
        <?php if (!empty($mensagemErro)): ?>
            <div class="erro"><?= htmlspecialchars($mensagemErro) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="nomeEquipa">Equipa:</label>
            <select name="nomeEquipa" id="nomeEquipa" required>
                <option value="" selected disabled>Equipa</option>
                <?php foreach ($equipas as $equipa): ?>
                    <option value="<?= htmlspecialchars($equipa['nomeEquipa']) ?>">
                        <?= htmlspecialchars($equipa['nomeEquipa']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="acao">Ação:</label>
            <select name="acao" id="acao" required>
                <option value="" selected disabled>Ação</option>
                <option value="adicionar">Adicionar elemento</option>
                <option value="remover">Remover elemento</option>
            </select>

            <label for="Elemento">Elemento:</label>
            <select name="Elemento" id="Elemento" required>
                <option value="" selected disabled>Elemento</option>
                <?php foreach ($elementos as $utilizador): ?>
                    <option value="<?= htmlspecialchars($utilizador['email']) ?>">
                        <?= htmlspecialchars($utilizador['email']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Executar</button>
        </form>
    </div>
</body>
</html>