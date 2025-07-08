<?php
require_once 'BLL/Logger_BLL.php';

$logger = new LoggerBLL();
$logs = $logger->obterLogs(); // assume que este método já existe
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Logs</title>
    <link rel="stylesheet" href="CSS/listar_logs.css">
    <script src="JS/logs.js"></script>
</head>
<body>
    <?php include 'cabecalho.php';   ?>

    <h2 style="text-align:center;">Histórico de Ações (Logs)</h2>

    <div id="modal">
        <div id="modal-content">
            <div id="modal-detalhes"></div>
            <button class="fechar-btn" onclick="fecharModal()">Fechar</button>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Ação</th>
                <th>Detalhes</th>
                <th>Data e Hora</th>
                <th>Alterar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= $log['idLog'] ?></td>
                <td><?= htmlspecialchars($log['Autoremail']) ?></td>
                <td><?= htmlspecialchars($log['acao']) ?></td>
                <td>
                    <button onclick="toggleDetalhes(<?= $log['idLog'] ?>)">Apresentar Detalhes</button>
                    <div class="detalhes" id="detalhes-<?= $log['idLog'] ?>">
                        <?= nl2br(htmlspecialchars($log['detalhes'])) ?>
                    </div>
                </td>
                <td><?= $log['dataHora'] ?></td>
                <td>
                    <form method="POST" action="API/eliminar_log.php" style="display:inline;" onsubmit="return confirm('Tens a certeza que queres apagar este log?');">
                        <input type="hidden" name="idLog" value="<?= $log['idLog'] ?>">
                        <button type="submit" class="remover-btn">Remover</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
