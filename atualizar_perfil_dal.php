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
        $sql = $this->conn->prepare("SELECT * FROM Utilizador JOIN DadosPessoaisColaborador ON DadosPessoaisColaborador.email=Utilizador.email
                                      JOIN DadosHabilitacoesColaborador ON DadosHabilitacoesColaborador.email=DadosPessoaisColaborador.email
                                      JOIN DadosFinanceirosColaborador ON DadosFinanceirosColaborador.email=DadosPessoaisColaborador.email
                                      JOIN DadosExtrasColaborador ON DadosExtrasColaborador.email=DadosPessoaisColaborador.email
                                      JOIN DadosContratoColaborador ON DadosContratoColaborador.email=DadosPessoaisColaborador.email
                                        WHERE Utilizador.email = ? AND Utilizador.password_hash=?");
        $sql->bind_param("ss", $email, $password);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();

        if($result){
            return $result;
        }
        return false;
    }

    function obterDDIs(){
        $sql=$this->conn->prepare("SELECT * FROM DDI");
        $sql->execute();
        $result=$sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function obterHabilitacoesLiterarias(){
        $sql=$this->conn->prepare("SELECT * FROM HabilitacoesLiterarias");
        $sql->execute();
        $result=$sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function obterRegimesHorarioTrabalho(){
        $sql=$this->conn->prepare("SELECT * FROM RegimeHorarioTrabalho");
        $sql->execute();
        $result=$sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function obterSexo(){
        $sql=$this->conn->prepare("SELECT * FROM Sexo");
        $sql->execute();
        $result=$sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function obterSituacaoIrs(){
        $sql=$this->conn->prepare("SELECT * FROM SituacaoIrs");
        $sql->execute();
        $result=$sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function obterTipoContrato(){
        $sql=$this->conn->prepare("SELECT * FROM TipoContrato");
        $sql->execute();
        $result=$sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function atualizarDadosPessoais($numMec, $email, $nomeAbreviado, $dataNascimento, $designacaoDdiTelemovel, $telemovel, $sexo,
    $numPorta, $rua, $codPost, $localidade, $nacionalidade, $designacaoDdiContacto, $contacto, $contactoEmergencia, 
    $grauRelacionamento, $matricula){
        $sql=$this->conn->prepare("UPDATE DadosPessoaisColaborador SET numMec=$numMec, email=$email, nomeAbreviado=$nomeAbreviado,
        dataNascimento=$dataNascimento, designacaoDdiTelemovel=$designacaoDdiTelemovel, telemovel=$telemovel, sexo=$sexo
        numPorta=$numPorta, rua=$rua, codPost=$codPost, localidade=$localidade, nacionalidade=$nacionalidade, 
        designacaoDdiContacto=$designacaoDdiContacto, contacto=$contacto, contactoEmergencia=$contactoEmergencia, 
        grauRelacionamento=$grauRelacionamento, matricula=$matricula WHERE email=$email");
        $sql->execute();
    }

    function atualizarDadosHabilitacoes($email, $habLiterarias, $curso, $frequencia){
        $sql=$this->conn->prepare("UPDATE DadosHabilitacoesColaborador SET email=$email, habLiterarias=$habLiterarias,
        curso=$curso, frequencia=$frequencia WHERE email=$email");
        $sql->execute();
    }

    function atualizarDadosFinanceiros($email, $cc, $nif, $niss, $situacaoIrs, $numDependentes, $iban, $remuneracao){
        $sql=$this->conn->prepare("UPDATE DadosFinanceirosColaborador SET email=$email, cc=$cc, nif=$nif, niss=$niss,
        situacaoIrs=$situacaoIrs, numDependentes=$numDependentes, iban=$iban, remuneracao=$remuneracao WHERE email=$email");
        $sql->execute();
    }

    function atualizarDadosExtras($email, $cartaoContinente, $VoucherNos){
        $sql=$this->conn->prepare("UPDATE DadosExtrasColaborador SET email=$email, cartaoContinente=$cartaoContinente,
        VoucherNos=$VoucherNos WHERE email=$email");
        $sql->execute();
    }

    function atualizarDadosContrato($email, $tipoContrato, $regimeHorarioTrabalho, $dataInicio, $dataFim){
        $sql=$this->conn->prepare("UPDATE DadosContratoColaborador SET email=$email, tipoContrato=$tipoContrato,
        regimeHorarioTrabalho=$regimeHorarioTrabalho, dataInicio=$dataInicio, dataFim=$dataFim WHERE email=$email");
        $sql->execute();
    }
}