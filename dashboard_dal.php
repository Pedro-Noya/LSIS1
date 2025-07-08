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

    //function obterEquipaPorEmail($email){
        /*$sql=$this->conn->prepare("SELECT nomeEquipa FROM ColaboradoresEquipa WHERE email=?");
        $sql->bind_param("s",$email);
        $sql->execute();
        $equipa=$sql->get_result()->fetch_assoc();
        if($equipa){
            return $equipa;
        }
        return false;
    }*/

    function obterMembrosEquipa_Coordenador($email){
        //1º Passo: Determinar a equipa à qual pertence o Coordenador em questão!
        //$equipa=obterEquipaPorEmail($email);
        $sql=$this->conn->prepare("SELECT nomeEquipa FROM ColaboradoresEquipa WHERE email=?");
        $sql->bind_param("s",$email);
        $sql->execute();
        $equipa=$sql->get_result()->fetch_assoc();
        
        $sql=$this->conn->prepare("SELECT ColaboradoresEquipa.email FROM ColaboradoresEquipa JOIN Utilizador ON ColaboradoresEquipa.email=Utilizador.email WHERE
        ColaboradoresEquipa.nomeEquipa=? AND Utilizador.papel<=2");
        $sql->bind_param("s",$equipa["nomeEquipa"]);
        $sql->execute();
        $colaboradores=$sql->get_result()->fetch_all(MYSQLI_ASSOC);
        if($colaboradores){
            return $colaboradores;
        }
        return false;
    }

    function obterMembrosEquipa_RH($email){
        //1º Passo: Determinar a equipa à qual pertence o Coordenador em questão!
        //$equipa=obterEquipaPorEmail($email);
        $sql=$this->conn->prepare("SELECT nomeEquipa FROM ColaboradoresEquipa WHERE email=?");
        $sql->bind_param("s",$email);
        $sql->execute();
        $equipa=$sql->get_result()->fetch_assoc();
        
        $sql=$this->conn->prepare("SELECT ColaboradoresEquipa.email FROM ColaboradoresEquipa JOIN Utilizador ON ColaboradoresEquipa.email=Utilizador.email WHERE
        ColaboradoresEquipa.nomeEquipa=? AND Utilizador.papel<=3");
        $sql->bind_param("s",$equipa["nomeEquipa"]);
        $sql->execute();
        $colaboradores=$sql->get_result()->fetch_all(MYSQLI_ASSOC);
        if($colaboradores){
            return $colaboradores;
        }
        return false;
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