<?php
class Formacoes_DAL {
    private $conn;

    function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "tlantic");
        if ($this->conn->connect_error) {
            die("Erro na ligação: " . $this->conn->connect_error);
        }
    }

    public function listarTodas() {
        $stmt = $this->conn->prepare("SELECT * FROM Formacoes");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obterFormacaoPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Formacoes WHERE idFormacao = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function criarFormacao($titulo, $imagemPath, $nivelEnsino, $duracao, $localizacao, $horario, $descricao = 'Descrição não fornecida') {
        $stmt = $this->conn->prepare("
            INSERT INTO Formacoes (titulo, imagem, nivelEnsino, duracao, localizacao, horario, descricao)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssiisss", $titulo, $imagemPath, $nivelEnsino, $duracao, $localizacao, $horario, $descricao);
        return $stmt->execute();
    }

    public function verificarInscricao($email, $idFormacao) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM FormacoesColaboradores WHERE email = ? AND idFormacao = ?");
        $stmt->bind_param("si", $email, $idFormacao);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }

    public function obterEstadoInscricao($email, $idFormacao) {
        $stmt = $this->conn->prepare("SELECT estado FROM FormacoesColaboradores WHERE email = ? AND idFormacao = ?");
        $stmt->bind_param("si", $email, $idFormacao);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['estado'] : null;
    }

    public function inscreverColaborador($email, $idFormacao) {
        $stmt = $this->conn->prepare("INSERT INTO FormacoesColaboradores (email, idFormacao, estado) VALUES (?, ?, 0)");
        $stmt->bind_param("si", $email, $idFormacao);
        return $stmt->execute();
    }
        
    public function atualizarEstadoFormacao($email, $idFormacao, $novoEstado) {
        $stmt = $this->conn->prepare("
            UPDATE FormacoesColaboradores
            SET estado = ?
            WHERE email = ? AND idFormacao = ?
        ");
        $stmt->bind_param("isi", $novoEstado, $email, $idFormacao);
        return $stmt->execute();
    }

    public function obterInscricoesPorFormacao($idFormacao) {
        $stmt = $this->conn->prepare("SELECT * FROM FormacoesColaboradores WHERE idFormacao = ?");
        $stmt->bind_param("i", $idFormacao);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

}
?>