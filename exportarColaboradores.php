<meta charset="UTF-8">
<?php
$conn = new mysqli('localhost', 'root', '', 'tlantic');

if ($conn->connect_error) {
    die("Erro na ligação à base de dados: " . $this->conn->connect_error);
}

if(isset($_GET["email"])){
    $email=$_GET["email"];
    $sql = $conn->prepare("SELECT * FROM utilizador JOIN DadosPessoaisColaborador ON DadosPessoaisColaborador.email=Utilizador.email
                            JOIN DadosHabilitacoesColaborador ON DadosHabilitacoesColaborador.email=DadosPessoaisColaborador.email
                            JOIN DadosFinanceirosColaborador ON DadosFinanceirosColaborador.email=DadosPessoaisColaborador.email
                            JOIN DadosExtrasColaborador ON DadosExtrasColaborador.email=DadosPessoaisColaborador.email
                            JOIN DadosContratoColaborador ON DadosContratoColaborador.email=DadosPessoaisColaborador.email
                            WHERE Utilizador.email=?");
    $sql->bind_param("s",$email);
    $sql->execute();
    $result=$sql->get_result()->fetch_assoc();
    
} else{
    $sql = $conn->prepare("SELECT * FROM utilizador JOIN DadosPessoaisColaborador ON DadosPessoaisColaborador.email=Utilizador.email
                            JOIN DadosHabilitacoesColaborador ON DadosHabilitacoesColaborador.email=DadosPessoaisColaborador.email
                            JOIN DadosFinanceirosColaborador ON DadosFinanceirosColaborador.email=DadosPessoaisColaborador.email
                            JOIN DadosExtrasColaborador ON DadosExtrasColaborador.email=DadosPessoaisColaborador.email
                            JOIN DadosContratoColaborador ON DadosContratoColaborador.email=DadosPessoaisColaborador.email
                            ");
    $sql->execute();
    $result = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
}
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Colaboradores.xls");

//Para a tabela dos Dados Pessoais
echo "<h1>Dados Pessoais</h1>
<table border='1'>";
echo "<tr><th>Email</th><th>Nome</th><th>Nº Mecanográfico</th><th>Nome Abreviado</th>
<th>Data de Nascimento</th><th>Designação DDI Telemóvel</th><th>Telemóvel</th>
<th>Sexo</th><th>Nº da Porta</th><th>Rua</th><th>Código Postal</th><th>Localidade</th>
<th>Nacionalidade</th><th>Designação DDI Contacto</th><th>Contacto</th><th>Contacto de Emergência</th>
<th>Grau de Relacionamento</th><th>Matrícula</th>
</tr>";
if(isset($email)){
    echo "<tr>";
    echo "<td>{$result['email']}</td>";
    echo "<td>{$result['nome']}</td>";
    echo "<td>{$result['numMec']}</td>";
    echo "<td>{$result['nomeAbreviado']}</td>";
    echo "<td>{$result['dataNascimento']}</td>";
    echo "<td>{$result['designacaoDdiTelemovel']}</td>";
    echo "<td>{$result['telemovel']}</td>";
    echo "<td>{$result['sexo']}</td>";
    echo "<td>{$result['numPorta']}</td>";
    echo "<td>{$result['rua']}</td>";
    echo "<td>{$result['codPost']}</td>";
    echo "<td>{$result['localidade']}</td>";
    echo "<td>{$result['nacionalidade']}</td>";
    echo "<td>{$result['designacaoDdiContacto']}</td>";
    echo "<td>{$result['contacto']}</td>";
    echo "<td>{$result['contactoEmergencia']}</td>";
    echo "<td>{$result['grauRelacionamento']}</td>";
    echo "<td>{$result['matricula']}</td>";

    echo "</tr>";
} else{
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['nome']}</td>";
        echo "<td>{$row['numMec']}</td>";
        echo "<td>{$row['nomeAbreviado']}</td>";
        echo "<td>{$row['dataNascimento']}</td>";
        echo "<td>{$row['designacaoDdiTelemovel']}</td>";
        echo "<td>{$row['telemovel']}</td>";
        echo "<td>{$row['sexo']}</td>";
        echo "<td>{$row['numPorta']}</td>";
        echo "<td>{$row['rua']}</td>";
        echo "<td>{$row['codPost']}</td>";
        echo "<td>{$row['localidade']}</td>";
        echo "<td>{$row['nacionalidade']}</td>";
        echo "<td>{$row['designacaoDdiContacto']}</td>";
        echo "<td>{$row['contacto']}</td>";
        echo "<td>{$row['contactoEmergencia']}</td>";
        echo "<td>{$row['grauRelacionamento']}</td>";
        echo "<td>{$row['matricula']}</td>";
        echo "</tr>";
    }
}
echo "</table>";
echo "<br><h1>Dados Habilitações</h1><br>";
echo "<table border='1'>";
echo "<tr><th>Email</th><th>Habilitações Literárias</th><th>Curso</th><th>Frequência</th>
</tr>";
if(isset($email)){
    echo "<tr>";
    echo "<td>{$result['email']}</td>";
    echo "<td>{$result['habLiterarias']}</td>";
    echo "<td>{$result['curso']}</td>";
    echo "<td>{$result['frequencia']}</td>";
    echo "</tr>";
} else{
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['habLiterarias']}</td>";
        echo "<td>{$row['curso']}</td>";
        echo "<td>{$row['frequencia']}</td>";
        echo "</tr>";
    }
}
echo "</table>";
echo "<br><h1>Dados Financeiros</h1><br>";
echo "<table border='1'>";
echo "<tr><th>Email</th><th>CC</th><th>NIF</th><th>NISS</th><th>Situação IRS</th>
<th>Nº de Dependentes</th><th>IBAN</th><th>Remuneração</th>
</tr>";
if(isset($email)){
    echo "<tr>";
    echo "<td>{$result['email']}</td>";
    echo "<td>{$result['cc']}</td>";
    echo "<td>{$result['nif']}</td>";
    echo "<td>{$result['niss']}</td>";
    echo "<td>{$result['situacaoIrs']}</td>";
    echo "<td>{$result['numDependentes']}</td>";
    echo "<td>{$result['iban']}</td>";
    echo "<td>{$result['remuneracao']}</td>";

    echo "</tr>";
} else{
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['cc']}</td>";
        echo "<td>{$row['nif']}</td>";
        echo "<td>{$row['niss']}</td>";
        echo "<td>{$row['situacaoIrs']}</td>";
        echo "<td>{$row['numDependentes']}</td>";
        echo "<td>{$row['iban']}</td>";
        echo "<td>{$row['remuneracao']}</td>";
        echo "</tr>";
    }
}
echo "</table>";
echo "<br><h1>Dados Extras</h1><br>";
echo "<table border='1'>";
//Dentro do if e do else, vai ser preciso ir buscar o voucher NOS associado a cada Colaborador - não tem lógica mostrar o ID.
echo "<tr><th>Email</th><th>Cartão Continente</th><th>Voucher NOS</th>
</tr>";
if(isset($email)){
    //Vamos buscar o voucher NOS
    $sql=$conn->prepare("SELECT voucherNos FROM VoucherNos WHERE idVoucherNos=?");
    $sql->bind_param("i",$result["idVoucherNos"]);
    $sql->execute();
    $voucherNos=$sql->get_result()->fetch_assoc();
    echo "<tr>";
    echo "<td>{$result['email']}</td>";
    echo "<td>{$result['cartaoContinente']}</td>";
    if($voucherNos!=null){
        echo "<td>{$voucherNos['voucherNos']}</td>";
    } else {
        echo "<td>Este Colaborador não tem voucher NOS a si associado.";
    }
    echo "</tr>";
} else{
    foreach ($result as $row) {
        //A mesma coisa aqui em baixo
        $sql=$conn->prepare("SELECT voucherNos FROM VoucherNos WHERE idVoucherNos=?");
        $sql->bind_param("i",$row["idVoucherNos"]);
        $sql->execute();
        $voucherNos=$sql->get_result()->fetch_assoc();
        echo "<tr>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['cartaoContinente']}</td>";
        if($voucherNos!=null){
            echo "<td>{$voucherNos['voucherNos']}</td>";
        } else {
            echo "<td>Este Colaborador não tem voucher NOS a si associado.";
        }
        echo "</tr>";
    }
}
echo "</table>";
echo "<br><h1>Dados Contratuais</h1><br>";
echo "<table border='1'>";
echo "<tr><th>Email</th><th>Tipo de Contrato</th><th>Regime de Horário de Trabalho</th>
<th>Data de Início</th><th>Data de Fim</th>
</tr>";
if(isset($email)){
    echo "<tr>";
    echo "<td>{$result['email']}</td>";
    echo "<td>{$result['tipoContrato']}</td>";
    echo "<td>{$result['regimeHorarioTrabalho']}</td>";
    echo "<td>{$result['dataInicio']}</td>";
    echo "<td>{$result['dataFim']}</td>";
    echo "</tr>";
} else{
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['tipoContrato']}</td>";
        echo "<td>{$row['regimeHorarioTrabalho']}</td>";
        echo "<td>{$row['dataInicio']}</td>";
        echo "<td>{$row['dataFim']}</td>";
        echo "</tr>";
    }
}
echo "</table>";