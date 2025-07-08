<?php
require_once 'BLL/Logger_BLL.php';

session_start();

$loggerBLL = new LoggerBLL();
$email = $_SESSION['email'];
$_SESSION = array();
session_destroy();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

$loggerBLL->registarLog($email, "Logout efetuado com sucesso");
header("Location: login.php");
?>