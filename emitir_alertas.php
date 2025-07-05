<?php
require_once 'BLL/Alertas_BLL.php';

session_start();

$bll = new Alertas_BLL();
$alertasVencidos = [];

foreach ($bll->listarAlertas() as $alerta) {
    $dataUltimoEnvio = new DateTime($alerta['dataEmissao']);
    $hoje = new DateTime();
    $dias = (int)$alerta['periodicidade'];

    if ($dias > 0 && $dataUltimoEnvio->add(new DateInterval("P{$dias}D")) <= $hoje) {
        $alertasVencidos[] = $alerta;
    }
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Verificar Alertas</title>
    <link rel="stylesheet" href="CSS/alertas.css">
</head>
<body>
    <?php include 'cabecalho.php'; ?>

    <div class="container">
        <h1>Alertas Pendentes</h1>

        <?php if (empty($alertasVencidos)): ?>
            <p>Todos os alertas estão atualizados.</p>
        <?php else: ?>
            <?php foreach ($alertasVencidos as $alerta): ?>
                <div class="alerta-card" data-id="<?= $alerta['idAlerta'] ?>">
                    <p class="tipo"><strong>Tipo:</strong> <?= htmlspecialchars($alerta['tipo']) ?></p>
                    <p class="descricao"><strong>Descrição:</strong> <?= htmlspecialchars($alerta['descricao']) ?></p>
                    <p class="periodicidade"><strong>Periodicidade:</strong> <?= htmlspecialchars($alerta['periodicidade']) ?> dias</p>
                    <p class="email"><strong>Email:</strong> <?= htmlspecialchars($alerta['email']) ?></p>
                    <p><strong>Último envio:</strong> <?= htmlspecialchars($alerta['dataEmissao']) ?> (<?=calcularDiasVencido($alerta['dataEmissao'], $alerta['periodicidade'])?> dias de atraso)</p>
                    <button class="btn enviar-btn">Enviar Alerta</button>
                    <button class="btn descartar-btn">Descartar</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <script src="JS/emitir_alertas.js"></script>
</body>
</html>

<?php
function calcularDiasVencido($dataEmissao, $periodicidade) {
    $dataEmissaoDate = new DateTime($dataEmissao);
    $hoje = new DateTime();
    $proximaData = clone $dataEmissaoDate;
    $proximaData->modify("+$periodicidade days");

    if ($hoje > $proximaData) {
        return $proximaData->diff($hoje)->days;
    }
    return 0;
}
?>
