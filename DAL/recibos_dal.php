<?php
class DAL_Recibos {
    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    function obterFuncao($email) {
        $sql = $this->conn->prepare("SELECT papel FROM Utilizador WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        return $sql->get_result()->fetch_assoc();
    }

    function obterTodosUtilizadores() {
        $sql = $this->conn->prepare("SELECT email FROM Utilizador");
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function obterTodosRecibos() {
        $sql = $this->conn->prepare("SELECT * FROM RecibosVencimento");
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function obterRecibosDoUtilizador($email) {
        $sql = $this->conn->prepare("SELECT * FROM RecibosVencimento WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function inserirRecibo($nome, $vencimento, $email) {
        $sql = $this->conn->prepare("INSERT INTO RecibosVencimento (nomeRecibo, vencimento, email) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $nome, $vencimento, $email);
        return $sql->execute();
    }

    function obterTodosEmailsComRecibos() {
        $sql = $this->conn->prepare("SELECT DISTINCT email FROM RecibosVencimento");
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
