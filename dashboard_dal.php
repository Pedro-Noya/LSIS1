<?php
class DAL_Dashboard{
    private $conn;
    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    function obterFuncao($email){
        $sql=$this->conn->prepare("SELECT papel FROM Utilizador WHERE email=?");
        $sql->bind_param("s",$email);
        $sql->execute();
        $funcao=$sql->get_result()->fetch_assoc();
        if($funcao){
            return $funcao;
        }
        return false;
    }

    function obterEquipasDoUtilizador($email) {
        $sql = $this->conn->prepare("SELECT DISTINCT nomeEquipa FROM ColaboradoresEquipa WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function obterMembrosEquipaPorPapel($email, $papelMaximo){
        // Buscar todas as equipas do utilizador
        $sql = $this->conn->prepare("SELECT nomeEquipa FROM ColaboradoresEquipa WHERE email=?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result()->fetch_all(MYSQLI_ASSOC);

        $todosColaboradores = [];

        foreach ($result as $row) {
            $nomeEquipa = $row['nomeEquipa'];
            $sql2 = $this->conn->prepare("SELECT DISTINCT ColaboradoresEquipa.email FROM ColaboradoresEquipa 
                JOIN Utilizador ON ColaboradoresEquipa.email=Utilizador.email
                WHERE ColaboradoresEquipa.nomeEquipa=? AND Utilizador.papel <= ?");
            $sql2->bind_param("si", $nomeEquipa, $papelMaximo);
            $sql2->execute();
            $colaboradores = $sql2->get_result()->fetch_all(MYSQLI_ASSOC);
            $todosColaboradores = array_merge($todosColaboradores, $colaboradores);
        }

        // Remover duplicados
        $todosColaboradores = array_unique($todosColaboradores, SORT_REGULAR);
        return $todosColaboradores;
    }

    function obterMembrosDeUmaEquipa($nomeEquipa){
        $sql = $this->conn->prepare("SELECT DISTINCT ColaboradoresEquipa.email FROM ColaboradoresEquipa 
            JOIN Utilizador ON ColaboradoresEquipa.email=Utilizador.email 
            WHERE ColaboradoresEquipa.nomeEquipa=? AND Utilizador.papel<=3");
        $sql->bind_param("s", $nomeEquipa);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function obterMembrosDeUmaEquipaFiltrada($nomeEquipa, $papelMaximo) {
        $sql = $this->conn->prepare("SELECT DISTINCT ColaboradoresEquipa.email 
            FROM ColaboradoresEquipa 
            JOIN Utilizador ON ColaboradoresEquipa.email = Utilizador.email 
            WHERE ColaboradoresEquipa.nomeEquipa = ? AND Utilizador.papel <= ?");
        $sql->bind_param("si", $nomeEquipa, $papelMaximo);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function obterMembrosEquipa_Coordenador($email){
        return $this->obterMembrosEquipaPorPapel($email, 2);
    }

    function obterMembrosEquipa_RH($email){
        return $this->obterMembrosEquipaPorPapel($email, 3);
    }

    function obterDadosPrivadosColaborador($email){
        $sql=$this->conn->prepare("SELECT estado, dataCriacao, papel FROM Utilizador WHERE email=?");
        $sql->bind_param("s",$email);
        $sql->execute();
        return $result=$sql->get_result()->fetch_assoc();
    }

    function obterDadosPessoaisColaborador($email){
        $sql=$this->conn->prepare("SELECT dataNascimento, sexo, nacionalidade FROM DadosPessoaisColaborador WHERE email=?");
        $sql->bind_param("s",$email);
        $sql->execute();
        $result=$sql->get_result()->fetch_assoc();
        if($result){
            return $result;
        }
        return false;
    }

    function obterDadosFinanceirosColaborador($email){
        $sql=$this->conn->prepare("SELECT remuneracao FROM DadosFinanceirosColaborador WHERE email=?");
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