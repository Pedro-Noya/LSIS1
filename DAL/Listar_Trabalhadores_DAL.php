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
        $filename="Lista_Colaboradores";
        $file_ending="xls";
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=$filename.'.'.$file_ending");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $sep = "\t";

        $stmt=$this->conn->prepare("SELECT * FROM Utilizador");
        $stmt->execute();
        $resultado=$stmt->get_result();
        while ($property = mysqli_fetch_field($resultado)) { //fetch table field name
            echo $property->name."\t";
        }
        print("\n");    

        while($row = mysqli_fetch_row($resultado))  //fetch_table_data
        {
            $schema_insert = "";
            for($j=0; $j< mysqli_num_fields($resultado);$j++)
            {
                if(!isset($row[$j]))
                    $schema_insert .= "NULL".$sep;
                elseif ($row[$j] != "")
                    $schema_insert .= "$row[$j]".$sep;
                else
                    $schema_insert .= "".$sep;
            }
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
        }
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