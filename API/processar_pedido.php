<?php
session_start();

require_once '../BLL/Pedido_BLL.php';
require_once '../BLL/Logger_BLL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPedido = $_POST['idPedido'] ?? null;
    $acao = $_POST['acao'] ?? null;

    if ($idPedido && in_array($acao, ['aceitar', 'rejeitar'])) {
        $bll = new PedidoBLL();
        $estado = ($acao === 'aceitar') ? 1 : -1; // <-- aqui está a chave
        $bll->atualizarEstadoPedido($idPedido, $estado);
        $loggerBLL = new LoggerBLL();
        $loggerBLL->registarLog(
            $_SESSION['email'],
            "Pedido de ID: $idPedido foi $acao",
            "Estado: $estado"
        );
    }
}

header('Location: ../listar_pedidos.php');
exit;
