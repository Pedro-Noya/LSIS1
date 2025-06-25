<?php
class DAL_Atualizar{
    private $conn;
    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    function obterDadosPerfil($email, $password){
        $sql = $this->conn->prepare("SELECT * FROM Utilizador INNER JOIN FichaColaborador WHERE Utilizador.email = ? AND Utilizador.password_hash=? AND Utilizador.email=FichaColaborador.email");
        $sql->bind_param("ss", $email, $password);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();

        if($result){
            return $result;
        }
        return false;
    }
}