<?php
require_once "../DAL/Equipas_DAL.php";
require_once "../DAL/Mensagem_Equipa_DAL.php";
require_once "../DAL/Aniversario_Equipa_DAL.php";
session_start();

$nomeEquipa = $_GET['nome'] ?? null;
if (!$nomeEquipa) {
    echo "Equipa não especificada.";
    exit;
}

$MensagemEquipa_DAL = new MensagemEquipa_DAL();
$AniversarioEquipa_DAL = new AniversarioEquipa_DAL();

$mensagens = MensagemEquipa_DAL->obterMensagensPorEquipa($nomeEquipa);
$aniversarios = AniversarioEquipa_DAL->obterAniversariosPorEquipa($nomeEquipa);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Info da Equipa</title>
    <link rel="stylesheet" href="../CSS/chat.css">
    <script src="../JS/equipas_info.js" defer></script>
</head>
<body>
    <h2>Chat da Equipa: <?= htmlspecialchars($nomeEquipa) ?></h2>
    <div id="chat-container">
        <?php foreach ($mensagens as $msg): ?>
            <div class="mensagem"><strong><?= htmlspecialchars($msg['emailRemetente']) ?>:</strong> <?= htmlspecialchars($msg['mensagem']) ?> <em>(<?= $msg['dataHora'] ?>)</em></div>
        <?php endforeach; ?>
    </div>

    <form id="chat-form" method="POST" action="../API/enviar_mensagem.php">
        <input type="hidden" name="nomeEquipa" value="<?= htmlspecialchars($nomeEquipa) ?>">
        <textarea name="mensagem" required></textarea>
        <button type="submit">Enviar</button>
    </form>

    <h2>Aniversários dos Elementos</h2>
    <ul>
        <?php foreach ($aniversarios as $a): ?>
            <li><?= htmlspecialchars($a['email']) ?>: <?= date('d-m', strtotime($a['dataNascimento'])) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
