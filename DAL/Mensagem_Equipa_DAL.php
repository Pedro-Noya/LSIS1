<?php
class MensagemEquipa_DAL {
    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');

        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    public static function obterMensagensPorEquipa($nomeEquipa) {

        $stmt = $conn->prepare("SELECT * FROM MensagemEquipa WHERE nomeEquipa = ? ORDER BY dataHora ASC");
        $stmt->bind_param("s", $nomeEquipa);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function enviarMensagem($nomeEquipa, $email, $mensagem) {

        $stmt = $conn->prepare("INSERT INTO MensagemEquipa (nomeEquipa, emailRemetente, mensagem) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nomeEquipa, $email, $mensagem);
        $stmt->execute();
    }
}
