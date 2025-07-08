<?php
require_once 'BLL/Alertas_BLL.php';
require_once 'BLL/Logger_BLL.php';

session_start();

$bll = new Alertas_BLL();
$loggerBLL = new LoggerBLL();
$alertasVencidos = [];

foreach ($bll->listarAlertas() as $alerta) {
    $dataUltimoEnvio = new DateTime($alerta['dataEmissao']);
    $hoje = new DateTime();
    $dias = (int)$alerta['periodicidade'];

    if ($dias > 0 && $dataUltimoEnvio->add(new DateInterval("P{$dias}D")) <= $hoje) {
        $alertasVencidos[] = $alerta;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'])) {
    $resultado = $bll->enviarAlerta(
        $_POST['tipo'] ?? 'Documentação',
        $_POST['descricao'],
        $_POST['email']
    );
    if (!$resultado) {
        $mensagemErro = 'Erro ao enviar alerta único.';
    } else {
        $loggerBLL->registarLog($_SESSION['email'], "Enviou um alerta único do tipo: " . $_POST['tipo'], "Destinatário: " . $_POST["email"] ."\nDescrição: ". $_POST['descricao']);
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

    <?php if (!empty($mensagemErro)): ?>
        <div class="erro"><?= htmlspecialchars($mensagemErro) ?></div>
    <?php endif; ?>

    <div class="section-title">Alertas | Emitir Alertas</div>

    <br/>

    <div class="containers-row">
        <div class="container">
            <h1>Alertas</h1>

            <?php if (isset($_GET['sucesso'])): ?>
                <div class="alerta-card" style="background:#d4edda;color:#155724;">Alerta Emitido com sucesso!</div>
            <?php endif; ?>

            <div class="novo-alerta">
                <h2>Novo Alerta</h2>
                <form method="post">
                    <label>Tipo:</label><br/>
                    <select name="tipo" required style="width:100%;">
                        <option value="" selected disabled>Tipo de Alerta</option>
                        <option value="documentacao">Documentação</option>
                    </select>
                    <br/><br/>
                    <label>Corpo do email:</label><br/>
                        <textarea name="descricao" required style="width:100%;"></textarea>
                    <br/><br/>
                    <label>Email para envio:</label><br/>
                        <input type="email" name="email" required style="width:100%;">
                    <br/><br/>
                    <button class="btn" type="submit">Emitir Alerta</button>
                </form>
            </div>
        </div>

        <div class="container">
            <h1>Alertas Pendentes</h1>

            <?php if (empty($alertasVencidos)): ?>
                <p>Não há alertas pendentes.</p>
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
