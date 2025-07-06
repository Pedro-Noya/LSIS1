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

    public function criarEquipa($nomeEquipa, $localizacao, $dataCriacao) {
        $query = "INSERT INTO equipa (nomeEquipa, localizacao, dataCriacao) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }
        $stmt->bind_param("sss", $nomeEquipa, $localizacao, $dataCriacao);
        
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
}
?>
