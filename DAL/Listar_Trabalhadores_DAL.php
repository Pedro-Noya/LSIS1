<?php
class Listar_Trabalhadores_DAL {
    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');

        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    function exportarColaboradoresExcel($email){
        $sql = $this->conn->prepare("SELECT * FROM utilizador JOIN DadosPessoaisColaborador ON DadosPessoaisColaborador.email=Utilizador.email
                                      JOIN DadosHabilitacoesColaborador ON DadosHabilitacoesColaborador.email=DadosPessoaisColaborador.email
                                      JOIN DadosFinanceirosColaborador ON DadosFinanceirosColaborador.email=DadosPessoaisColaborador.email
                                      JOIN DadosExtrasColaborador ON DadosExtrasColaborador.email=DadosPessoaisColaborador.email
                                      JOIN DadosContratoColaborador ON DadosContratoColaborador.email=DadosPessoaisColaborador.email
                                    ");
        $sql->execute();
        $result = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Colaboradores.xls");

        echo "<table border='1'>";
        echo "<tr><th>Email</th><th>Nome</th><th>Nº Mecanográfico</th><th>Nome Abreviado</th>
        <th>Data de Nascimento</th><th>Designação DDI Telemóvel</th>
        </tr>";
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
        echo "</table>";
    }

    public function obterElementosPorEquipa($nomeEquipa, $db, $utilizadores) {
        if (!in_array($db, ['colaboradoresequipa', 'coordenadoresequipa'])) {
            die("Tabela inválida.");
        }

        $stmt = $this->conn->prepare("SELECT email FROM $db WHERE nomeEquipa = ?");
        $stmt->bind_param("s", $nomeEquipa);
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }
        $resultado = $stmt->get_result();
        $emails = $resultado->fetch_all(MYSQLI_ASSOC);
        $emails = array_column($emails, 'email');

        $return_list = [];

        foreach ($utilizadores as $utilizador) {
            if (in_array($utilizador['email'], $emails)) {
                $return_list[] = $utilizador;
            }
        }

        return $return_list;

    }

    public function definirPapel($email, $papel) {
        $stmt = $this->conn->prepare("UPDATE utilizador SET papel = ? WHERE email = ?");
        $stmt->bind_param("is", $papel, $email);
        
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }

        return true;
    }

    public function definirNivel($email, $nivel) {
        $stmt = $this->conn->prepare("UPDATE coordenador SET nivelHierarquico = ? WHERE email = ?");
        $stmt->bind_param("is", $nivel, $email);
        
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }

        return true;
    }

    public function verificarTabelaCoordenador($email) {
        $stmt = $this->conn->prepare("SELECT * FROM coordenador WHERE email = ?");
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }
        if ($stmt->get_result()->num_rows === 0) {
            $query = "INSERT INTO coordenador (email, nivelHierarquico) VALUES (?, 1)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $email);
            
            if (!$stmt->execute()) {
                die("Erro ao executar a query: " . $stmt->error);
            }
        }
    }

    public function getNivel($email) {
        $stmt = $this->conn->prepare("SELECT nivelHierarquico FROM coordenador WHERE email = ?");
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }
        $resultado = $stmt->get_result();
        
        if ($resultado && $resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            return $row['nivelHierarquico'];
        }
        
        return null;
    }
}
?>