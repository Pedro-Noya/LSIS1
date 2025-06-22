<?php
require_once __DIR__ . '/../DAL/Registo_Utilizador_DAL.php';

class Registo_Utilizador_BLL {
  private $dal;

  public function __construct() {
    $this->dal = new Registo_Utilizador_DAL();
  }

  public function registarUtilizador($nome, $email, $password, $confirmPassword, $role, $sexo, $nacionalidade, $dataNascimento, $tipoContrato, $dataInicio, $dataFim, $regimeHorarioTrabalho) {
    // 1. Verificar se as passwords coincidem
    if ($password !== $confirmPassword) {
      return "As palavras-passe não coincidem.";
    }

    // 2. Verificar se o utilizador já existe
    if ($this->dal->existeUtilizador($email)) {
      return "O utilizador já existe.";
    }

    // 3. Criar hash da password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 4. Inserir utilizador
    $sucesso_ut = $this->dal->createUtilizador(
      $nome,
      $email,
      $password_hash,
      $role
    );

    if (!$sucesso_ut) {
      return "Erro ao registar o utilizador.";
    }

    $sucesso_cu = $this->dal->createContratoUtilizador(
      $tipoContrato, 
      $dataInicio, 
      $dataFim, 
      $regimeHorarioTrabalho
    );

    // 5. Inserir dados adicionais do colaborador
    if (strtolower($role) === 'colaborador') {
      $sucesso_co = $this->dal->createFichaColaborador(
        $email, 
        $sexo, 
        $nacionalidade, 
        $dataNascimento
      );

      if (!$sucesso_co) {
        return "Erro ao criar ficha de colaborador.";
      }
    }

    return true; // Registo bem-sucedido
  }
}
?>
