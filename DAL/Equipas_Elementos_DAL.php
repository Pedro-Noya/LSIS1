<?php
class Equipa_Elementos_DAL {
    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');

        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    public function existeEquipa($nome_equipa) {
        $stmt = $this->conn->prepare("SELECT * FROM equipa WHERE nomeEquipa = ?");
        $stmt->bind_param("s", $nome_equipa);
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }
        $resultado = $stmt->get_result();

        if (!$resultado) {
            return false;
        }

        return true;
    }


    public function adicionarElemento($nomeEquipa, $emailElemento, $db) {

        if (!in_array($db, ['colaboradoresequipa'])) {
          die("Tabela inválida.");
        }
        // Verifica se o elemento já está na equipa
        $stmt = $this->conn->prepare("SELECT * FROM $db WHERE nomeEquipa = ? AND email = ?");
        $stmt->bind_param("ss", $nomeEquipa, $emailElemento);
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            return false;
        }

        // Adiciona o elemento à equipa
        $stmt = $this->conn->prepare("INSERT INTO $db (nomeEquipa, email) VALUES (?, ?)");
        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }
        $stmt->bind_param("ss", $nomeEquipa, $emailElemento);

        return $stmt->execute();
    }

    public function removerElemento($nomeEquipa, $emailElemento) {
        // Verifica se o elemento está na equipa
        $stmt = $this->conn->prepare("SELECT * FROM colaboradoresequipa WHERE nomeEquipa = ? AND email = ?");
        $stmt->bind_param("ss", $nomeEquipa, $emailElemento);
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 0) {
            // Verifica na tabela de coordenadores
            $stmt = $this->conn->prepare("SELECT * FROM coordenadoresequipa WHERE nomeEquipa = ? AND email = ?");
            $stmt->bind_param("ss", $nomeEquipa, $emailElemento);
            if (!$stmt->execute()) {
                die("Erro ao executar a query: " . $stmt->error);
            }
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 0) {
                return false; // Elemento não encontrado na equipa
            } else {
                // Remove da tabela de coordenadores
                $stmt = $this->conn->prepare("DELETE FROM coordenadoresequipa WHERE nomeEquipa = ? AND email = ?");
                if (!$stmt) {
                    die("Erro na preparação da query: " . $this->conn->error);
                }
                $stmt->bind_param("ss", $nomeEquipa, $emailElemento);
                return $stmt->execute();
            }
        } else {
            // Remove da tabela de colaboradores
            $stmt = $this->conn->prepare("DELETE FROM colaboradoresequipa WHERE nomeEquipa = ? AND email = ?");
            if (!$stmt) {
                die("Erro na preparação da query: " . $this->conn->error);
            }
            $stmt->bind_param("ss", $nomeEquipa, $emailElemento);
            return $stmt->execute();
        }
    }

    public function obterPapelPorEmail($emailElemento) {
        $stmt = $this->conn->prepare("SELECT * FROM utilizador WHERE email = ?");
        $stmt->bind_param("s", $emailElemento);
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }
        $resultado = $stmt->get_result();
        if ($resultado && $resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            return $row['papel'];
        }
        return null;
    }

    public function elementoTemEquipa($emailElemento) {
        // Verifica na tabela de colaboradores
        $stmt = $this->conn->prepare("SELECT * FROM colaboradoresequipa WHERE email = ?");
        $stmt->bind_param("s", $emailElemento);
        if (!$stmt->execute()) {
            die("Erro ao executar a query: " . $stmt->error);
        }
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            return true;
        }
    }

}
?>

