<?php
require_once 'RegistoUtilizador_dal.php';

class Registo_Utilizador_BLL {
    private $dal;

    public function __construct() {
        $this->dal = new Registo_Utilizador_DAL();
    }

    public function registarUtilizador($username, $email, $password, $confirmPassword) {
        // 1. Verificar se as passwords coincidem
        if ($password !== $confirmPassword) {
            return "As palavras-passe não coincidem.";
        }

        // 2. Verificar se o utilizador já existe
        if ($this->dal->existeUtilizador($username)) {
            return "O utilizador já existe.";
        }

        // 3. Criar hash da password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 4. Inserir utilizador
        $sucesso = $this->dal->createUtilizador($username, $email, $hashedPassword);

        if ($sucesso) {
            return true;
        } else {
            return "Erro ao registar o utilizador.";
        }
    }
}
?>
