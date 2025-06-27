<?php
class DAL_login{

  private $conn;
  function __construct() {
    $this->conn = new mysqli('localhost', 'root', '', 'tlantic');

    if ($this->conn->connect_error) {
      die("Erro na ligação à base de dados: " . $this->conn->connect_error);
    }
  }

  // Em vez de só retornar true/false, retorna o ID do utilizador ou false.
  function entrarUtilizador($email, $password) {
    $sql = $this->conn->prepare("SELECT * FROM Utilizador WHERE email = ? AND password_hash=?");
    $sql->bind_param("ss", $email, $password);
    $sql->execute();
    $result = $sql->get_result()->fetch_assoc();

    //if ($result && password_verify($password, $result['password'])) {
    if($result){
      return true;
    }
    return false;
  }
}
?>
