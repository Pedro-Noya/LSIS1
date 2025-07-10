<?php
require_once 'BLL/Pedido_BLL.php';
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([3,4]);

$bll = new PedidoBLL();
$pedidos = $bll->obterPedidosPendentes();

function estadoTexto($estado) {
    return match ((int)$estado) {
        -1 => 'Rejeitado',
        0  => 'Pendente',
        1  => 'Aceite',
        default => 'Desconhecido'
    };
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Listar Pedidos</title>
    <style>
        table { width: 90%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        button { margin: 2px; }
    </style>
</head>
<body>
    <?php include 'cabecalho.php'; ?>

    <h2 style="text-align:center;">Lista de Pedidos</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Razão</th>
                <th>Detalhes</th>
                <th>Data de Emissão</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?= $pedido['idPedido'] ?></td>
                <td><?= htmlspecialchars($pedido['email']) ?></td>
                <td><?= htmlspecialchars($pedido['tipo']) ?></td>
                <td class="detalhes">
                    <?php
                    switch ($pedido['tipo']) {
                        case 'Férias':
                            echo "<strong>Início:</strong> {$pedido['dataInicio']}<br><strong>Fim:</strong> {$pedido['dataFim']}";
                            break;
                        case 'Equipamento':
                            echo "<strong>Equipamento:</strong> {$pedido['equipamento']}<br><strong>Quantidade:</strong> {$pedido['quantidade']}";
                            break;
                        case 'Documentação':
                            echo "<strong>Dado:</strong> {$pedido['dado']}<br><strong>Novo Valor:</strong> {$pedido['novoValor']}";
                            break;
                        case 'Troca de turno':
                            echo "<strong>Data:</strong> {$pedido['dataTroca']}<br><strong>Turno:</strong> {$pedido['novoTurno']}";
                            break;
                        case 'Período de Trabalho Remoto':
                            echo "<strong>Início:</strong> {$pedido['dataInicioR']}<br><strong>Fim:</strong> {$pedido['dataFimR']}";
                            break;
                        case 'Assistência':
                            echo "<strong>Tipo:</strong> {$pedido['tipoAssistencia']}";
                            break;
                        default:
                            echo "-";
                    }
                    ?>
                </td>
                <td><?= nl2br(htmlspecialchars($pedido['razao'])) ?></td>
                <td><?= $pedido['dataPedido'] ?></td>
                <td><?= estadoTexto($pedido['estado']) ?></td>
                <td>
                    <?php if ((int)$pedido['estado'] === 0): ?>
                        <form method="POST" action="API/processar_pedido.php" style="display:inline;">
                            <input type="hidden" name="idPedido" value="<?= $pedido['idPedido'] ?>">
                            <button name="acao" value="aceitar">Aceitar</button>
                            <button name="acao" value="rejeitar">Rejeitar</button>
                        </form>
                    <?php else: ?>
                        (<?= estadoTexto($pedido['estado']) ?>)
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
