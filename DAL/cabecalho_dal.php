<?php
class DAL_Cabecalho{
    private $conn;
    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    function determinarFuncao($email){
        $sql=$this->conn->prepare("SELECT papel FROM Utilizador WHERE email=?");
        $sql->bind_param("s",$email);
        $sql->execute();
        $funcao=$sql->get_result();
        return $funcao->fetch_assoc();
    }
}
?>