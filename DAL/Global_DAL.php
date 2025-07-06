<?php
class Global_DAL {
    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');

        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    public function getUtilizadores() {
        $query = "SELECT * FROM utilizador";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEquipas() {
        $query = "SELECT * FROM equipa";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obterElementosPorEquipa($nomeEquipa, $db, $utilizadores) {
        if (!in_array($db, ['colaboradoresequipa', 'coordenadoresequipa'])) {
            die("Tabela inválida.");
        }

        $stmt = $this->conn->prepare("SELECT email FROM $db WHERE nomeEquipa = ?");
        $stmt->bind_param("s", $nomeEquipa);
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }
        $resultado = $stmt->get_result();
        $emails = $resultado->fetch_all(MYSQLI_ASSOC);
        $emails = array_column($emails, 'email');

        $return_list = [];

        foreach ($utilizadores as $utilizador) {
            if (in_array($utilizador['email'], $emails)) {
                $return_list[] = $utilizador;
            }
        }

        return $return_list;

    }

}
?>