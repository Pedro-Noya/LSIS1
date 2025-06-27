<?php
class DAL_Atualizar{
    private $conn;
    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    function obterDadosPerfil($email){
        $sql = $this->conn->prepare("SELECT * FROM utilizador JOIN DadosPessoaisColaborador ON DadosPessoaisColaborador.email=Utilizador.email
                                      JOIN DadosHabilitacoesColaborador ON DadosHabilitacoesColaborador.email=DadosPessoaisColaborador.email
                                      JOIN DadosFinanceirosColaborador ON DadosFinanceirosColaborador.email=DadosPessoaisColaborador.email
                                      JOIN DadosExtrasColaborador ON DadosExtrasColaborador.email=DadosPessoaisColaborador.email
                                      JOIN DadosContratoColaborador ON DadosContratoColaborador.email=DadosPessoaisColaborador.email
                                        WHERE Utilizador.email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();

        if($result){
            return $result;
        }
        return false;
    }
}