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

echo "<table border='1'>";
echo "<tr><th>Email</th><th>Nome</th><th>Nº Mecanográfico</th><th>Nome Abreviado</th>
<th>Data de Nascimento</th><th>Designação DDI Telemóvel</th>
</tr>";
if(isset($email)){
    echo "<tr>";
    echo "<td>{$result['email']}</td>";
    echo "<td>{$result['nome']}</td>";
    echo "<td>{$result['numMec']}</td>";
    echo "<td>{$result['nomeAbreviado']}</td>";
    echo "<td>{$result['dataNascimento']}</td>";
    echo "<td>{$result['designacaoDdiTelemovel']}</td>";
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
        echo "</tr>";
    }
}
echo "</table>";
