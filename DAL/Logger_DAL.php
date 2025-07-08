<?php
class LoggerDAL {
    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');

        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }
    
    public function registarLog($email, $acao, $detalhes = "Não existe mais Informação") {
        $stmt = $this->conn->prepare("INSERT INTO log (Autoremail, acao, detalhes) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $acao, $detalhes);
        if (!$stmt->execute()) {
            die("Erro ao inserir log: " . $stmt->error);
        }
    }

    public function obterLogs() {
        $stmt = $this->conn->prepare("SELECT * FROM log ORDER BY dataHora DESC");
        if (!$stmt->execute()) {
            die("Erro ao obter logs: " . $stmt->error);
        }
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function removerLog($idLog) {
        $stmt = $this->conn->prepare("DELETE FROM log WHERE idLog = ?");
        $stmt->bind_param("i", $idLog);
        if (!$stmt->execute()) {
            die("Erro ao remover log: " . $stmt->error);
        }
        return true;
    }
}