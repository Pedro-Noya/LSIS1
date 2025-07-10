<?php
session_start();

require_once '../BLL/Pedido_BLL.php';
require_once '../BLL/Logger_BLL.php';
require_once '../BLL/Formacoes_BLL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPedido = $_POST['idPedido'] ?? null;
    $acao = $_POST['acao'] ?? null;

    if ($idPedido && in_array($acao, ['aceitar', 'rejeitar'])) {
        $estado = ($acao === 'aceitar') ? 1 : -1;

        $bll = new PedidoBLL();
        $bll->atualizarEstadoPedido($idPedido, $estado);

        $loggerBLL = new LoggerBLL();
        $loggerBLL->registarLog(
            $_SESSION['email'],
            "Pedido de ID: $idPedido - Ação: $acao",
            "Estado: $estado"
        );

        // Verificar se é pedido de inscrição em formação
        if ($acao === 'aceitar') {
            $pedido = $bll->obterPedidoPorId($idPedido);

            if ($pedido && str_starts_with($pedido['tipo'], 'Inscrição em Formação')) {
                if (preg_match('/ID:\s*(\d+)/', $pedido['razao'], $matches)) {
                    $idFormacao = (int) $matches[1];
                    $email = $pedido['email'];

                    $formacoesBLL = new Formacoes_BLL();
                    $formacoesBLL->atualizarEstadoFormacao($email, $idFormacao, 1);
                }
            }
        }
    }
}
header('Location: ../listar_pedidos.php');
exit;
