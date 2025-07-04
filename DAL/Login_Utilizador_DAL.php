<?php
class Login_Utilizador_DAL {
    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');

        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    public function obterUtilizadorPorEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM utilizador WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function verificarTabelaCoordenador($email) {
        $stmt = $this->conn->prepare("SELECT * FROM coordenador WHERE email = ?");
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }
        if ($stmt->get_result()->num_rows === 0) {
            $query = "INSERT INTO coordenador (email, nivelHierarquico) VALUES (?, 1)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $email);
            
            if (!$stmt->execute()) {
                die("Erro ao executar a query: " . $stmt->error);
            }
        }
    }
}
?>