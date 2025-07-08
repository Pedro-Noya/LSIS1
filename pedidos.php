<?php
session_start();

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


    if ($tipo === 'Documentação') {
        $dado = $_POST['dado'] ?? '';
        $novoValor = $_POST['novo_valor'] ?? '';
    }

    $bll = new PedidoBLL();
    if ($bll->registarPedido($email, $tipo, $razao, $idDocumento, $dadosExtras)) {
        $sucesso = "Pedido registado com sucesso.";
        $loggerBLL = new LoggerBLL();
        $detalhes = null;
        switch ($tipo) {
            case 'Férias':
                $tipo = 'Férias';
                $detalhes = "Período: De " . $dadosExtras['data_inicio_ferias'] . " até " . $dadosExtras['data_fim_ferias']
                            . "\nRazão: $razao";
                break;
            case 'Equipamento':
                $tipo = 'Equipamento';
                $detalhes = "Equipamento: " . $dadosExtras['equipamento'] . "\nQuantidade: " . $dadosExtras['quantidade']
                            . "\nRazão: $razao";
                break;
            case 'Documentação':
                $tipo = 'Documentação';
                $detalhes = "Dado: " . $dadosExtras['dado'] . "\nNovo Valor: " . $dadosExtras['novo_valor']
                            . "\nRazão: $razao";
                break;
            case 'Troca de turno':
                $tipo = 'Troca de turno';
                $detalhes = "Data de troca: " . $dadosExtras['data_troca'] . "\nNovo turno: " . $dadosExtras['novo_turno']
                            . "\nRazão: $razao";
                break;
            case 'Período de Trabalho Remoto':
                $tipo = 'Trabalho Remoto';
                $detalhes = "Período: De " . $dadosExtras['data_inicio_remoto'] . " até " . $dadosExtras['data_fim_remoto']
                            . "\nRazão: $razao";
                break;
            case 'Assistência':
                $detalhes = "Tipo de assistência: " . $dadosExtras['tipo_assistencia'] . "\nRazão: $razao";
                $tipo = 'Assistência';
                break;
            default:
                $tipo = 'Pedido Não Especificado';
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
    <script src="JS/pedidos.js" defer></script>
</head>
<body>
    <?php include 'cabecalho.php'; ?>

    <h2>Registar Pedido</h2>

    <?php if (isset($erro)) : ?>
        <div class="erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <?php if (isset($sucesso)) : ?>
        <div class="sucesso"><?= htmlspecialchars($sucesso) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        Email:
        <input type="email" name="email" disabled value='<?= isset($_SESSION["email"]) ? $_SESSION["email"] : "ERRO: NÃO HÁ CONTA LOGGED IN" ?>'><br>

        Tipo:
        <select name="tipo" id="tipo" required>
            <option value="" selected disabled>-- Selecione --</option>
            <option value="Férias">Férias</option>
            <option value="Equipamento">Equipamento</option>
            <option value="Documentação">Documentação</option>
            <option value="Troca de turno">Troca de turno</option>
            <option value="Período de Trabalho Remoto">Período de Trabalho Remoto</option>
            <option value="Assistência">Assistência</option>
        </select><br><br>

        <div id="FeriasExtras" style="display:none;">
            Data de início: <input type="date" name="data_inicio_ferias"><br>
            Data de fim: <input type="date" name="data_fim_ferias"><br><br>
        </div>

        <div id="EquipamentoExtras" style="display:none;">
            Equipamento: <input type="text" name="equipamento"><br><br>x\
            Quantidade: <input type="number" name="quantidade" min="1"><br><br>
        </div>

        <div id="DocExtras" style="display:none;">
            Dado a atualizar: <input type="text" name="dado"><br>
            Novo valor: <input type="text" name="novo_valor"><br><br>
        </div>

        <div id="TrocaTurnoExtras" style="display:none;">
            Data de troca: <input type="date" name="data_troca"><br/>
            Novo turno:
            <select name="novo_turno">
                <option value="Manhã">Manhã</option>
                <option value="Tarde">Tarde</option>
                <option value="Noite">Noite</option>
            </select><br/><br/>
        </div>

        <div id="RemotoExtras" style="display:none;">
            Data de início: <input type="date" name="data_inicio_remoto"><br>
            Data de fim: <input type="date" name="data_fim_remoto"><br><br>
        </div>

        <div id="AssistenciaExtras" style="display:none;">
            Tipo de assistência: <input type="text" name="tipo_assistencia"><br>
        </div>

        Razão / Descrição:
        <textarea name="razao" required></textarea><br>

        <label>Comprovativo / Documento: (OPCIONAL) </label>
        <input type="file" name="documento"><br><br>

        <button type="submit">Submeter Pedido</button>
    </form>
</body>
</html>
