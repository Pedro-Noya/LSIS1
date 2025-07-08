<?php
class PedidoDAL {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro de ligação: " . $this->conn->connect_error);
        }
    }

        public function registarPedido($email, $tipo, $razao, $idDocumento = null, $extras = []) {
        $estado = 0;

        $stmt = $this->conn->prepare("INSERT INTO pedido (email, tipo, razao, estado, idDocumento) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $email, $tipo, $razao, $estado, $idDocumento);
        if ($stmt->execute()) {
            $id = $this->conn->insert_id;
        } else {
            die("Erro ao inserir documento: " . $stmt->error);
        }


        switch ($tipo) {
            case 'Férias':
                $stmt = $this->conn->prepare("INSERT INTO pedidoferias (idPedido, dataInicio, dataFim) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $id, $extras['data_inicio_ferias'], $extras['data_fim_ferias']);
                break;
            case 'Equipamento':
                $stmt = $this->conn->prepare("INSERT INTO pedidoequipamento (idPedido, equipamento, quantidade) VALUES (?, ?, ?)");
                $stmt->bind_param("isi", $id, $extras['equipamento'], $extras['quantidade']);
                break;
            case 'Documentação':
                $stmt = $this->conn->prepare("INSERT INTO pedidodocumentacao (idPedido, dado, novoValor) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $id, $extras['dado'], $extras['novo_valor']);
                break;
            case 'Troca de turno':
                $stmt = $this->conn->prepare("INSERT INTO pedidotrocaturno (idPedido, dataTroca, novoTurno) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $id, $extras['data_troca'], $extras['novo_turno']);
                break;
            case 'Período de Trabalho Remoto':
                $stmt = $this->conn->prepare("INSERT INTO pedidoremoto (idPedido, dataInicioR, dataFimR) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $id, $extras['data_inicio_remoto'], $extras['data_fim_remoto']);
                break;
            case 'Assistência':
                $stmt = $this->conn->prepare("INSERT INTO pedidoassistencia (idPedido, tipoAssistencia) VALUES (?, ?)");
                $stmt->bind_param("is", $id, $extras['tipo_assistencia']);
                break;
            default:
                return true; // tipo genérico sem extras
        }

        return $stmt->execute();
    }

    public function obterPedidosPendentes() {
        $sql = "SELECT p.*, 
                       pf.dataInicio, pf.dataFim,
                       pe.equipamento, pe.quantidade,
                       pd.dado, pd.novoValor,
                       pt.dataTroca, pt.novoTurno,
                       pr.dataInicioR, pr.dataFimR,
                       pa.tipoAssistencia
                FROM pedido p
                LEFT JOIN pedidoferias pf ON p.idPedido = pf.idPedido
                LEFT JOIN pedidoequipamento pe ON p.idPedido = pe.idPedido
                LEFT JOIN pedidodocumentacao pd ON p.idPedido = pd.idPedido
                LEFT JOIN pedidotrocaturno pt ON p.idPedido = pt.idPedido
                LEFT JOIN pedidoremoto pr ON p.idPedido = pr.idPedido
                LEFT JOIN pedidoassistencia pa ON p.idPedido = pa.idPedido
                WHERE p.estado = 0
                ORDER BY p.dataPedido ASC";

        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function atualizarEstadoPedido($idPedido, $estado) {
        $stmt = $this->conn->prepare("UPDATE pedido SET estado = ? WHERE idPedido = ?");
        $stmt->bind_param("ii", $estado, $idPedido);
        return $stmt->execute();
    }
}
?>
