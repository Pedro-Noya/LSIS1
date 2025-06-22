<?php
class Registo_Utilizador_DAL {
  private $conn;

  function __construct() {
    $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
    if ($this->conn->connect_error) {
      die("Erro na ligação à base de dados: " . $this->conn->connect_error);
    }
  }

  function createUtilizador($nome, $email, $password_hash) {
    $query = "INSERT INTO utilizador (nome, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
      die("Erro na preparação da query: " . $this->conn->error);
    }
    $stmt->bind_param("sss", $nome, $email, $password_hash);
    
    return $stmt->execute();
  }

  function createFichaColaborador($email, $sexo, $nacionalidade, $dataNascimento) {
    $query = "INSERT INTO fichaColaborador (email, sexo, nacionalidade, dataNascimento) VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
      die("Erro na preparação da query: " . $this->conn->error);
    }
    $stmt->bind_param("ssss", $email, $sexo, $nacionalidade, $dataNascimento);
    return $stmt->execute();
  }

  function existeUtilizador($email) {
    $stmt = $this->conn->prepare("SELECT * FROM utilizador WHERE email = ?");
    if (!$stmt) {
      die("Erro na preparação da query: " . $this->conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
  }
}
?>