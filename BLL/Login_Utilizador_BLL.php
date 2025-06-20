<?php
require_once __DIR__ . '/../DAL/Login_Utilizador_DAL.php';

class Login_Utilizador_BLL {
    private $dal;

    public function __construct() {
        $this->dal = new Login_Utilizador_DAL();
    }

    public function autenticarUtilizador($email, $password) {
        if (empty($email) || empty($password)) {
            return "Por favor, preencha todos os campos.";
        }

        $user = $this->dal->obterUtilizadorPorEmail($email);
        if (!$user) {
            return "Utilizador não encontrado.";
        }

        if (!password_verify($password, $user['password_hash'])) {
            return "Palavra-passe incorreta.";
        }

        // Tudo certo, login com sucesso
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        return true;
    }
}
