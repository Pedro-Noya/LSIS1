<?php
require_once __DIR__ . '/../DAL/Registo_Utilizador_DAL.php';
require_once __DIR__ . '/../BLL/Global_BLL.php';

class Registo_Utilizador_BLL {
  private $dal;

  public function __construct() {
    $this->dal = new Registo_Utilizador_DAL();
  }

  public function registarUtilizador($emailPessoal, $nome, $email, $password) {

    // 2. Verificar se o utilizador já existe
    if ($this->dal->existeUtilizador($email)) {
      return "O utilizador já existe.";
    }

    // 3. Criar hash da password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 4. Inserir utilizador
    $sucesso = $this->dal->createUtilizador(
      $email,
      $nome,
      $password_hash,
      1
    );

    if (!$sucesso) {
      return "Erro ao registar o utilizador.";
    }

    enviarEmailRegisto($emailPessoal, $email, $nome, $password);

    return true;
  }
}
?>
