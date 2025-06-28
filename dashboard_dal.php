<?php
class DAL_Dashboard{
    private $conn;
    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    function obterDadosColaborador($email){
        $sql=$this->conn->prepare("SELECT dataNascimento, sexo FROM DadosPessoaisColaborador WHERE email=?");
        $sql->bind_param("s",$email);
        $sql->execute();
        $result=$sql->get_result()->fetch_assoc();
        if($result){
            return $result;
        }
        return false;
    }

    function obterEmailColaborador_Coordenador($email){
        $sql = $this->conn->prepare("SELECT ColaboradoresEquipa.email FROM ColaboradoresEquipa JOIN CoordenadoresEquipa
        ON ColaboradoresEquipa.nomeEquipa=CoordenadoresEquipa.nomeEquipa
        WHERE CoordenadoresEquipa.email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result()->fetch_all(MYSQLI_ASSOC);

        if($result){
            return $result;
        }
        return false;
    }
}