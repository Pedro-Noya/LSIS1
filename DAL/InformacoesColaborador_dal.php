<?php
class DAL_Atualizar{
    private $conn;
    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    function obterDadosUtilizador($email){
        $sql=$this->conn->prepare("SELECT * FROM utilizador WHERE Utilizador.email=?");
        $sql->bind_param("s",$email);
        $sql->execute();
        $result=$sql->get_result()->fetch_assoc();
        if($result){
            return $result;
        } else{
            return false;
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

    function obterNacionalidade(){
        $sql=$this->conn->prepare("SELECT nacionalidade FROM MoedaNacionalidade");
        $sql->execute();
        $result=$sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function obterRemuneracao(){
        $sql=$this->conn->prepare("SELECT * FROM Moeda");
        $sql->execute();
        $result=$sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function obterVoucherNos(){
        $estado=0;
        $sql=$this->conn->prepare("SELECT * FROM VoucherNos WHERE estado=?");
        $sql->bind_param("i",$estado);
        $sql->execute();
        $result=$sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function obterDataVoucher($idVoucherNos){
        $sql=$this->conn->prepare("SELECT voucherNos FROM VoucherNos JOIN DadosExtrasColaborador
        ON VoucherNos.idVoucherNos=DadosExtrasColaborador.idVoucherNos
        WHERE VoucherNos.idVoucherNos=?");
        $sql->bind_param("i",$idVoucherNos);
        $sql->execute();
        $result=$sql->get_result();
        return $result->fetch_assoc();
    }

    function removerVoucher($idVoucherNos){
        $estado=0;
        $sql=$this->conn->prepare("UPDATE VoucherNos SET estado = ? WHERE idVoucherNos = ?");
        $sql->bind_param("ii",$estado,$idVoucherNos);
        $sql->execute();
    }

    function adicionarVoucher($idVoucherNos){
        $estado=1;
        $sql=$this->conn->prepare("UPDATE VoucherNos SET estado = ? WHERE idVoucherNos = ?");
        $sql->bind_param("ii",$estado,$idVoucherNos);
        $sql->execute();
    }

    function obterEquipasColaborador($email){
        $sql=$this->conn->prepare("SELECT nomeEquipa FROM Equipa
        JOIN ColaboradoresEquipa ON Equipa.nomeEquipa=ColaboradoresEquipa.nomeEquipa
        JOIN ColaboradoresEquipa ON ColaboradoresEquipa.email=Utilizador.email
        WHERE Utilizador.email=?");
        $sql->bind_param("s",$email);
        $sql->execute();
        $result=$sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function atualizarEstado($email){
        $estado=1;
        $sql=$this->conn->prepare("UPDATE Utilizador SET
        estado = ?
        WHERE email = ?");
        $sql->bind_param("is",$estado,$email);
        $sql->execute();
    }
    function atualizarDadosPessoais($numMec, $email, $nomeAbreviado, $dataNascimento, $designacaoDdiTelemovel, $telemovel, $sexo,
    $numPorta, $rua, $codPost, $localidade, $nacionalidade, $designacaoDdiContacto, $contacto, $contactoEmergencia, 
    $grauRelacionamento, $matricula){
        $newEmail=$email;
        $sql = $this->conn->prepare("UPDATE DadosPessoaisColaborador SET
        numMec = ?,
        email = ?,
        nomeAbreviado = ?,
        dataNascimento = ?,
        designacaoDdiTelemovel = ?,
        telemovel = ?,
        sexo = ?,
        numPorta = ?,
        rua = ?,
        codPost = ?,
        localidade = ?,
        nacionalidade = ?,
        designacaoDdiContacto = ?,
        contacto = ?,
        contactoEmergencia = ?,
        grauRelacionamento = ?,
        matricula = ?
        WHERE email = ?");

        $sql->bind_param('issssssissssssssss', $numMec, $newEmail, $nomeAbreviado, $dataNascimento, $designacaoDdiTelemovel, $telemovel,
        $sexo, $numPorta, $rua, $codPost, $localidade, $nacionalidade, $designacaoDdiContacto, $contacto, $contactoEmergencia,
        $grauRelacionamento, $matricula, $email);

        $sql->execute();
    }

    function registarDadosPessoais($numMec, $email, $nomeAbreviado, $dataNascimento, $designacaoDdiTelemovel, $telemovel, $sexo,
    $numPorta, $rua, $codPost, $localidade, $nacionalidade, $designacaoDdiContacto, $contacto, $contactoEmergencia, 
    $grauRelacionamento, $matricula){
        $newEmail=$email;
        $sql = $this->conn->prepare("INSERT INTO DadosPessoaisColaborador(
        numMec,
        email,
        nomeAbreviado,
        dataNascimento,
        designacaoDdiTelemovel,
        telemovel,
        sexo,
        numPorta,
        rua,
        codPost,
        localidade,
        nacionalidade,
        designacaoDdiContacto,
        contacto,
        contactoEmergencia,
        grauRelacionamento,
        matricula) VALUES(
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $sql->bind_param('issssssisssssssss', $numMec, $newEmail, $nomeAbreviado, $dataNascimento, $designacaoDdiTelemovel, $telemovel,
        $sexo, $numPorta, $rua, $codPost, $localidade, $nacionalidade, $designacaoDdiContacto, $contacto, $contactoEmergencia,
        $grauRelacionamento, $matricula);

        $sql->execute();
    }

    function atualizarDadosHabilitacoes($email, $habLiterarias, $curso, $frequencia){
        $newEmail=$email;
        $sql=$this->conn->prepare("UPDATE DadosHabilitacoesColaborador SET
        email = ?,
        habLiterarias = ?,
        curso = ?,
        frequencia = ?
        WHERE email = ?");

        $sql->bind_param("sssss", $newEmail, $habLiterarias, $curso, $frequencia, $email);

        $sql->execute();
    }

    function registarDadosHabilitacoes($email, $habLiterarias, $curso, $frequencia){
        $newEmail=$email;
        $sql=$this->conn->prepare("INSERT INTO DadosHabilitacoesColaborador (
        email,
        habLiterarias,
        curso,
        frequencia) VALUES (?, ?, ?, ?)");

        $sql->bind_param("ssss", $newEmail, $habLiterarias, $curso, $frequencia);

        $sql->execute();
    }

    function atualizarDadosFinanceiros($email, $cc, $nif, $niss, $situacaoIrs, $numDependentes, $iban, $remuneracao){
        $newEmail=$email;
        $sql=$this->conn->prepare("UPDATE DadosFinanceirosColaborador SET
        email = ?,
        cc = ?,
        nif = ?,
        niss = ?,
        situacaoIrs = ?,
        numDependentes = ?,
        iban = ?,
        remuneracao = ?
        WHERE email = ?");

        $sql->bind_param("sssssisss", $newEmail, $cc, $nif, $niss, $situacaoIrs, $numDependentes, $iban, $remuneracao, $email);

        $sql->execute();
    }

    function registarDadosFinanceiros($email, $cc, $nif, $niss, $situacaoIrs, $numDependentes, $iban, $remuneracao){
        $newEmail=$email;
        $sql=$this->conn->prepare("INSERT INTO DadosFinanceirosColaborador(
        email,
        cc,
        nif,
        niss,
        situacaoIrs,
        numDependentes,
        iban,
        remuneracao) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");

        $sql->bind_param("sssssiss", $newEmail, $cc, $nif, $niss, $situacaoIrs, $numDependentes, $iban, $remuneracao);

        $sql->execute();
    }

    

    function atualizarDadosExtras($email, $cartaoContinente, $voucherNos){
        $newEmail=$email;
        if (is_null($voucherNos) || $voucherNos==""){
            $sql = $this->conn->prepare("UPDATE DadosExtrasColaborador SET
            email = ?,
            cartaoContinente = ?,
            idVoucherNos = NULL
            WHERE email = ?");
            $sql->bind_param("sss", $newEmail, $cartaoContinente, $email);
        } else {
            $sql = $this->conn->prepare("UPDATE DadosExtrasColaborador SET
            email = ?,
            cartaoContinente = ?,
            idVoucherNos = ?
            WHERE email = ?");
            $sql->bind_param("ssis", $newEmail, $cartaoContinente, $voucherNos, $email);
        }
        $sql->execute();
    }

    function registarDadosExtras($email, $cartaoContinente, $voucherNos){
        if(is_null($voucherNos) || $voucherNos==""){
            $sql=$this->conn->prepare("INSERT INTO DadosExtrasColaborador(email, cartaoContinente, idVoucherNos)
            VALUES(?, ?, NULL)");
            $sql->bind_param("ss",$email,$cartaoContinente);
        } else{
            $sql=$this->conn->prepare("INSERT INTO DadosExtrasColaborador(email, cartaoContinente, idVoucherNos)
            VALUES(?, ?, ?)");
            $sql->bind_param("ssi",$email,$cartaoContinente,$voucherNos);
        }
        $sql->execute();
    }

    /*function atualizarDadosContrato_Colaborador($email, $regimeHorarioTrabalho, $dataInicio, $dataFim){
        $newEmail=$email;
        $sql=$this->conn->prepare("UPDATE DadosContratoColaborador SET
        email = ?,
        regimeHorarioTrabalho = ?,
        dataInicio = ?,
        dataFim = ?
        WHERE email = ?");

        $sql->bind_param("sssss", $newEmail, $regimeHorarioTrabalho, $dataInicio, $dataFim, $email);

        $sql->execute();
    }*/

    function atualizarDadosContrato_RH($email, $tipoContrato, $regimeHorarioTrabalho, $dataInicio, $dataFim){
        $newEmail=$email;
        $sql=$this->conn->prepare("UPDATE DadosContratoColaborador SET
        email = ?,
        tipoContrato = ?,
        regimeHorarioTrabalho = ?,
        dataInicio = ?,
        dataFim = ?
        WHERE email = ?");

        $sql->bind_param("ssssss", $newEmail, $tipoContrato, $regimeHorarioTrabalho, $dataInicio, $dataFim, $email);

        $sql->execute();
    }

    function registarDadosContrato($email, $tipoContrato, $regimeHorarioTrabalho, $dataInicio, $dataFim){
        $newEmail=$email;
        $sql=$this->conn->prepare("INSERT INTO DadosContratoColaborador (
        email,
        tipoContrato,
        regimeHorarioTrabalho,
        dataInicio,
        dataFim) VALUES (?, ?, ?, ?, ?)");

        $sql->bind_param("sssss", $newEmail, $tipoContrato, $regimeHorarioTrabalho, $dataInicio, $dataFim);

        $sql->execute();
    }

    function atualizarEstadoColaborador($email){
        $newEmail=$email;
        $estado=1;
        $sql=$this->conn->prepare("UPDATE Utilizador SET estado = ? WHERE email = ?");

        $sql->bind_param("is", $estado, $newEmail);
        $sql->execute();
    }

    function atualizarPedidos($email, $rua, $numPorta){
        $dataLimite="2025-08-10";
        $sql=$this->conn->prepare("INSERT INTO PedidoMorada(ruaNova, numPortaNova, dataLimite, email) VALUES(
        ?, ?, ?, ?)");
        $sql->bind_param("siss", $rua, $numPorta, $dataLimite, $email);
        $sql->execute();
    }
}