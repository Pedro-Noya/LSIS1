<?php
class MensagemEquipa_DAL {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    public function obterMensagensPorEquipa($nomeEquipa) {
        $stmt = $this->conn->prepare("SELECT * FROM MensagemEquipa WHERE nomeEquipa = ? ORDER BY dataHora ASC");
        $stmt->bind_param("s", $nomeEquipa);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function enviarMensagem($nomeEquipa, $email, $mensagem) {
        $stmt = $this->conn->prepare("INSERT INTO MensagemEquipa (nomeEquipa, emailRemetente, mensagem) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nomeEquipa, $email, $mensagem);
        $stmt->execute();
    }
}

