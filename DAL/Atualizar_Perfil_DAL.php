<?php
class Atualizar_Perfil_DAL {
  private $conn;

  function __construct() {
    $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
    if ($this->conn->connect_error) {
      die("Erro na ligação à base de dados: " . $this->conn->connect_error);
    }
  }

  function atualizarUtilizador($nome, $email, $password_hash, $role) {
    $query = "UPDATE utilizador SET email = ?, password_hash = ?, role = ? WHERE nome = ?";
    $stmt = $this->conn->prepare($query);
    if ($stmt === false) {
      die("Erro na preparação da query: " . $this->conn->error);
    }
    $stmt->bind_param("ssss", $email, $password_hash, $role, $nome);
    return $stmt->execute();
  }

  function getUtilizadorPornome($nome) {
    $stmt = $this->conn->prepare("SELECT * FROM utilizador WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }
}
?>
