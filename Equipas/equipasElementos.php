<?php
require_once '../BLL/Equipas_Elementos_BLL.php';
require_once '../BLL/Global_BLL.php';

session_start();

$mensagemErro = '';

$globalbll = new Global_BLL();
$equipas = $globalbll->getEquipas();
$elementos = $globalbll->getUtilizadores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeEquipa = $_POST['nomeEquipa'] ?? '';
    $emailElemento = $_POST['Elemento'] ?? '';
    $acao = $_POST['acao'] ?? '';

    $bll = new Equipas_Elementos_BLL();
    if ($acao === 'remover') {
        // Remover elemento da equipa
        $resultado = $bll->removerElementoEquipa($nomeEquipa, $emailElemento);
    } else {
        // Adicionar elemento à equipa
        if (empty($nomeEquipa) || empty($emailElemento)) {
            $mensagemErro = "Por favor, preencha todos os campos.";
            return;
        }
        
        $resultado = $bll->adicionarElementoEquipa($nomeEquipa, $emailElemento);
    }

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
    <link rel="stylesheet" href="../CSS/global.css" />
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
            <!-- Selecionar equipa -->
            <label for="nomeEquipa">Equipa:</label>
            <select name="nomeEquipa" id="nomeEquipa" required>
                <option value="" selected disabled>Equipa</option>
                <?php foreach ($equipas as $equipa): ?>
                    <option value="<?= htmlspecialchars($equipa['nomeEquipa']) ?>">
                        <?= htmlspecialchars($equipa['nomeEquipa']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Adicionar ou remover -->
            <label for="acao">Ação:</label>
            <select name="acao" id="acao" required>
                <option value="" selected disabled>Ação</option>
                <option value="adicionar">Adicionar elemento</option>
                <option value="remover">Remover elemento</option>
            </select>

            <!-- Email do elemento -->
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