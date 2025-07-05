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

    public function existeAlerta($tipo, $email, $periodicidade, $descricao) {
        $stmt = $this->conn->prepare("SELECT idAlerta FROM alerta WHERE tipo = ? AND email = ? AND periodicidade = ? AND descricao = ?");
        $stmt->bind_param("ssis", $tipo, $email, $periodicidade, $descricao);
        $stmt->execute();
        $stmt->bind_result($idAlerta);
        if ($stmt->fetch()) {
            return $idAlerta;
        } else {
            return null;
        }
    }

    public function atualizarAlerta($idAlerta, $tipo, $descricao, $periodicidade, $email) {
        $stmt = $this->conn->prepare("UPDATE alerta SET tipo = ?, descricao = ?, periodicidade = ?, email = ? WHERE idAlerta = ?");
        $stmt->bind_param("ssisi", $tipo, $descricao, $periodicidade, $email, $idAlerta);
        if ($stmt->execute()) {
            return true;
        } else {
            return "Erro ao atualizar alerta: " . $stmt->error;
        }
    }

    public function eliminarAlerta($idAlerta) {
        $stmt = $this->conn->prepare("DELETE FROM alerta WHERE idAlerta = ?");
        $stmt->bind_param("i", $idAlerta);
        if ($stmt->execute()) {
            return true;
        } else {
            return "Erro ao eliminar alerta: " . $stmt->error;
        }
    }

    public function atualizardataEmissao($idAlerta, $data) {
        $stmt = $this->conn->prepare("UPDATE alerta SET dataEmissao = ? WHERE idAlerta = ?");
        $stmt->bind_param("si", $data, $idAlerta);
        if ($stmt->execute()) {
            return true;
        } else {
            return "Erro ao atualizar data de emissão: " . $stmt->error;
        }
    }
}
?>