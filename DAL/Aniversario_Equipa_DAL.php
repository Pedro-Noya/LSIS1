<?php
class AniversarioEquipa_DAL {
    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');

        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }


    public function obterAniversariosPorEquipa($nomeEquipa) {
        $stmt = $this->conn->prepare("
            SELECT u.nome, dpc.email, dpc.dataNascimento
            FROM DadosPessoaisColaborador dpc
            INNER JOIN Utilizador u ON u.email = dpc.email
            INNER JOIN ColaboradoresEquipa ce ON dpc.email = ce.email
            WHERE ce.nomeEquipa = ?
        ");
        $stmt->bind_param("s", $nomeEquipa);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

}
