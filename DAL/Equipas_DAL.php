<?php
class Equipa_DAL {
    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');

        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    public function obterEquipaPorNome($nome_equipa) {
        $stmt = $this->conn->prepare("SELECT * FROM equipa WHERE nomeEquipa = ?");
        $stmt->bind_param("s", $nome_equipa);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function criarEquipa($nomeEquipa, $dataCriacao) {
        $query = "INSERT INTO equipa (nomeEquipa, dataCriacao) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }
        $stmt->bind_param("ss", $nomeEquipa, $dataCriacao);
        
        return $stmt->execute();
    }

    public function obterEquipas() {
        $query = "SELECT * FROM equipa";
        $resultado = $this->conn->query($query);
        if (!$resultado) {
            die("Erro na consulta: " . $this->conn->error);
        }
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obterEquipasPorEmail($email) {
        $stmt = $this->conn->prepare("
            SELECT nomeEquipa FROM ColaboradoresEquipa
            WHERE email = ?
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function existeEquipa($nomeEquipa) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM Equipa WHERE nomeEquipa = ?");
        $stmt->bind_param("s", $nomeEquipa);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }

}
?>
