<?php
class Registo_Utilizador_DAL {
  private $conn;

  function __construct() {
    $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
    if ($this->conn->connect_error) {
      die("Erro na ligação à base de dados: " . $this->conn->connect_error);
    }
  }

  function createUtilizador($nome, $email, $password_hash, $papel) {
    $query = "INSERT INTO utilizador (nome, email, password_hash, papel) VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
      die("Erro na preparação da query: " . $this->conn->error);
    }
    $stmt->bind_param("sssi", $nome, $email, $password_hash, $papel);
    
    return $stmt->execute();
  }

  function createFichaColaborador($email, $sexo, $nacionalidade, $dataNascimento, $tipoContrato, $dataInicio, $dataFim, $regimeHorarioTrabalho, $contacto, $situacaoIrs, $numDependentes, $remuneracao, $habLiterarias, $curso, $frequencia) {
    $query = "INSERT INTO fichacolaborador (email, sexo, nacionalidade, dataNascimento, tipoContrato, dataInicio, dataFim, regimeHorarioTrabalho, contacto, situacaoIrs, numDependentes, remuneracao, habLiterarias, curso, frequencia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
      die("Erro na preparação da query: " . $this->conn->error);
    }
    $stmt->bind_param("ssssssssssiisss", $email, $sexo, $nacionalidade, $dataNascimento, $tipoContrato, $dataInicio, $dataFim, $regimeHorarioTrabalho, $contacto, $situacaoIrs, $numDependentes, $remuneracao, $habLiterarias, $curso, $frequencia);
    if ($stmt->execute()) {
      $stmt->insert_id;
      return true;
    } else {
      return false;
    }
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