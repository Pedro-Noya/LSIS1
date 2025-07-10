<?php
require_once __DIR__ . '/../DAL/Pedido_DAL.php';

class PedidoBLL {
    private $dal;

    public function __construct() {
        $this->dal = new PedidoDAL();
    }

    public function registarPedido($email, $tipo, $razao, $idDocumento = null, $dadosExtras = []) {
        return $this->dal->registarPedido($email, $tipo, $razao, $idDocumento, $dadosExtras);
    }

    public function obterPedidosPendentes() {
        return $this->dal->obterPedidosPendentes();
    }

    public function atualizarEstadoPedido($idPedido, $estado) {
        return $this->dal->atualizarEstadoPedido($idPedido, $estado);
    }

    public function obterPedidoPorID($idPedido) {
        return $this->dal->obterPedidoPorID($idPedido);
    }

}
?>
