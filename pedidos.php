<?php
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([1,2,3,4]);

require_once 'BLL/Pedido_BLL.php';
require_once 'BLL/Global_BLL.php';
require_once 'BLL/Logger_BLL.php';

$erro = null;
$sucesso = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $razao = $_POST['razao'] ?? '';
    $idDocumento = null;

    $dadosExtras = [
        'data_inicio_ferias' => $_POST['data_inicio_ferias'] ?? null,
        'data_fim_ferias' => $_POST['data_fim_ferias'] ?? null,
        'equipamento' => $_POST['equipamento'] ?? null,
        'quantidade' => $_POST['quantidade'] ?? null,
        'dado' => $_POST['dado'] ?? null,
        'novo_valor' => $_POST['novo_valor'] ?? null,
        'data_troca' => $_POST['data_troca'] ?? null,
        'novo_turno' => $_POST['novo_turno'] ?? null,
        'data_inicio_remoto' => $_POST['data_inicio_remoto'] ?? null,
        'data_fim_remoto' => $_POST['data_fim_remoto'] ?? null,
        'tipo_assistencia' => $_POST['tipo_assistencia'] ?? null
    ];

    if (isset($_FILES['documento']) && $_FILES['documento']['error'] === UPLOAD_ERR_OK) {
        $nomeTemporario = $_FILES['documento']['tmp_name'];
        $conteudo = file_get_contents($nomeTemporario);
        $globalBLL = new Global_BLL();
        $idDocumento = $globalBLL->criarDocumento($tipo, $conteudo, 0);
    }

    $bll = new PedidoBLL();
    if ($bll->registarPedido($email, $tipo, $razao, $idDocumento, $dadosExtras)) {
        $sucesso = "Pedido registado com sucesso.";
        $loggerBLL = new LoggerBLL();
        $detalhes = null;
        switch ($tipo) {
            case 'Férias':
                $detalhes = "Período: De " . $dadosExtras['data_inicio_ferias'] . " até " . $dadosExtras['data_fim_ferias'] . "\nRazão: $razao";
                break;
            case 'Equipamento':
                $detalhes = "Equipamento: " . $dadosExtras['equipamento'] . "\nQuantidade: " . $dadosExtras['quantidade'] . "\nRazão: $razao";
                break;
            case 'Documentação':
                $detalhes = "Dado: " . $dadosExtras['dado'] . "\nNovo Valor: " . $dadosExtras['novo_valor'] . "\nRazão: $razao";
                break;
            case 'Troca de turno':
                $detalhes = "Data de troca: " . $dadosExtras['data_troca'] . "\nNovo turno: " . $dadosExtras['novo_turno'] . "\nRazão: $razao";
                break;
            case 'Período de Trabalho Remoto':
                $detalhes = "Período: De " . $dadosExtras['data_inicio_remoto'] . " até " . $dadosExtras['data_fim_remoto'] . "\nRazão: $razao";
                break;
            case 'Assistência':
                $detalhes = "Tipo de assistência: " . $dadosExtras['tipo_assistencia'] . "\nRazão: $razao";
                break;
        }
        $loggerBLL->registarLog($email, "Registou um Pedido de $tipo", $detalhes);
    } else {
        $erro = "Erro ao registar pedido. Verifique os dados.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Submeter Pedido</title>
    <link rel="stylesheet" href="CSS/pedidos.css">
    <script src="JS/pedidos.js" defer></script>
</head>
<body>
    <?php include 'cabecalho.php'; ?>

    <div class="titulo-pagina">
        <h1>Registar Pedido</h1>
    </div>

    <?php if (isset($erro)) : ?>
        <div class="erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <?php if (isset($sucesso)) : ?>
        <div class="sucesso"><?= htmlspecialchars($sucesso) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Email:</label>
        <input type="email" name="email" disabled value="<?= htmlspecialchars($_SESSION["email"] ?? 'ERRO') ?>">

        <label>Tipo:</label>
        <select name="tipo" id="tipo" required>
            <option value="" selected disabled>-- Selecione --</option>
            <option value="Férias">Férias</option>
            <option value="Equipamento">Equipamento</option>
            <option value="Documentação">Documentação</option>
            <option value="Troca de turno">Troca de turno</option>
            <option value="Período de Trabalho Remoto">Período de Trabalho Remoto</option>
            <option value="Assistência">Assistência</option>
        </select>

        <div id="FeriasExtras" class="hidden">
            <label>Data de início:</label>
            <input type="date" name="data_inicio_ferias">

            <label>Data de fim:</label>
            <input type="date" name="data_fim_ferias">
        </div>

        <div id="EquipamentoExtras" class="hidden">
            <label>Equipamento:</label>
            <input type="text" name="equipamento">

            <label>Quantidade:</label>
            <input type="number" name="quantidade" min="1">
        </div>

        <div id="DocExtras" class="hidden">
            <label>Dado a atualizar:</label>
            <input type="text" name="dado">

            <label>Novo valor:</label>
            <input type="text" name="novo_valor">
        </div>

        <div id="TrocaTurnoExtras" class="hidden">
            <label>Data de troca:</label>
            <input type="date" name="data_troca">

            <label>Novo turno:</label>
            <select name="novo_turno">
                <option value="Manhã">Manhã</option>
                <option value="Tarde">Tarde</option>
                <option value="Noite">Noite</option>
            </select>
        </div>

        <div id="RemotoExtras" class="hidden">
            <label>Data de início:</label>
            <input type="date" name="data_inicio_remoto">

            <label>Data de fim:</label>
            <input type="date" name="data_fim_remoto">
        </div>

        <div id="AssistenciaExtras" class="hidden">
            <label>Tipo de assistência:</label>
            <input type="text" name="tipo_assistencia">
        </div>

        <label>Razão / Descrição:</label>
        <textarea name="razao" required></textarea>

        <label>Comprovativo / Documento: (opcional)</label>
        <input type="file" name="documento">

        <button type="submit">Submeter Pedido</button>
    </form>
</body>
</html>
