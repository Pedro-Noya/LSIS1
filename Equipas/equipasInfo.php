<?php
require_once "../DAL/Equipas_DAL.php";
require_once "../DAL/Mensagem_Equipa_DAL.php";
require_once "../DAL/Aniversario_Equipa_DAL.php";
require_once "../BLL/Global_BLL.php";
require_once __DIR__ . "/../verificar_acesso.php";
verificarAcesso([1,2,3,4]);


$nomeEquipa = $_GET['nome'] ?? null;
$email = $_SESSION['email'] ?? null;
$EquipasDAL = new Equipa_DAL();

if (!$nomeEquipa || !$EquipasDAL->existeEquipa($nomeEquipa)) {
    // Mostrar equipas do utilizador
    $equipasDoUtilizador = $EquipasDAL->obterEquipasPorEmail($email);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Selecionar Equipa</title>
        <link rel="stylesheet" href="../CSS/chat.css">
    </head>
    <body>
        <?php include "../cabecalho.php"; ?>
        <h2>Escolha uma equipa para visualizar:</h2>
        <ul>
            <?php if (empty($equipasDoUtilizador)): ?>
                Nenhuma equipa encontrada.
            <?php else: ?>
                <?php foreach ($equipasDoUtilizador as $eq): ?>
                    <li><a href="equipasInfo.php?nome=<?= urlencode($eq['nomeEquipa']) ?>">
                        <?= htmlspecialchars($eq['nomeEquipa']) ?>
                    </a></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </body>
    </html>
    <?php
    exit;
}

$GlobalBLL = new Global_BLL();
$MensagemEquipa_DAL = new MensagemEquipa_DAL();
$AniversarioEquipa_DAL = new AniversarioEquipa_DAL();

$mensagens = $MensagemEquipa_DAL->obterMensagensPorEquipa($nomeEquipa);
$aniversarios = $AniversarioEquipa_DAL->obterAniversariosPorEquipa($nomeEquipa);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Info da Equipa</title>
    <link rel="stylesheet" href="../CSS/chat.css">
    <script src="../JS/equipas_info.js" defer></script>
</head>
<body>
    <?php include "../cabecalho.php"; ?>
    <h2>Chat da Equipa: <?= htmlspecialchars($nomeEquipa) ?></h2>
    <div id="chat-container">
        <?php foreach ($mensagens as $msg): ?>
            <?php $Remetente = $GlobalBLL->getUtilizadorporEmail($msg['emailRemetente']); ?>
            <div class="mensagem"><strong><?= htmlspecialchars($Remetente['nome']) ?>:</strong> <?= htmlspecialchars($msg['mensagem']) ?> <em>(<?= $msg['dataHora'] ?>)</em></div>
        <?php endforeach; ?>
    </div>

    <form id="chat-form" method="POST" action="../API/enviar_mensagem.php">
        <input type="hidden" name="nomeEquipa" value="<?= htmlspecialchars($nomeEquipa) ?>">
        <textarea name="mensagem" required></textarea>
        <button type="submit">Enviar</button>
    </form>

    <h2>Aniversários dos Elementos</h2>
    <ul>
        <?php if (empty($aniversarios)): ?>
            <li>Nenhum aniversário registrado para esta equipa.</li>
        <?php else: ?>
            <?php foreach ($aniversarios as $aniversario): ?>
                <li><?= htmlspecialchars($aniversario['nome']) ?>: <?= date('d/m', strtotime($aniversario['dataNascimento'])) ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</body>
</html>
