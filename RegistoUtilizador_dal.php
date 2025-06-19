<?php
class Registo_Utilizador_DAL{

  private $conn;
  function __construct() {
    $this->conn = new mysqli('localhost', 'root', '', 'tlantic_db');

    if ($this->conn->connect_error) {
      die("Erro na ligação à base de dados: " . $this->conn->connect_error);
    }
  }

  function createUtilizador($username, $email, $password_hash, $role = 'collaborator') {
    if ($this->conn) {
      $query = "INSERT INTO user (username, email, password_hash, role) VALUES (?, ?, ?, ?)";
      $stmt = $this->conn->prepare($query);

      if ($stmt === false) {
        die("Erro na preparação da query: " . $this->conn->error);
      }

      $stmt->bind_param("ssss", $username, $email, $password_hash, $role);
      return $stmt->execute();
    }
    return false;
  }

  function existeUtilizador($username) {
    $stmt = $this->conn->prepare("SELECT * FROM user WHERE username = ?");
    if ($stmt === false) {
      die("Erro na preparação da query: " . $this->conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
  }
}
?>