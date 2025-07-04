<?php

class Alertas_DAL {
    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    public function cadastrarAlerta($tipo, $descricao, $periodicidade, $email, $data) {
        $stmt = $this->conn->prepare("INSERT INTO alerta (tipo, descricao, periodicidade, email, dataEmissao, idDocumento) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("ssiss", $tipo, $descricao, $periodicidade, $email, $data);
        if ($stmt->execute()) {
            return true;
        } else {
            return "Erro ao executar a consulta: " . $stmt->error;
        }
    }

    public function listarAlertas() {
        $query = "SELECT * FROM alerta";
        $result = $this->conn->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "Erro ao obter alertas: " . $this->conn->error;
        }
    }
}
?>