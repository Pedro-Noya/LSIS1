<?php
require_once __DIR__ . "/../BLL/Formacoes_BLL.php";
require_once __DIR__ . "/../BLL/Logger_BLL.php";
require_once __DIR__ . "/../verificar_acesso.php";
verificarAcesso([3, 4]);

$email = $_POST['email'] ?? '';
$id = $_POST['idFormacao'] ?? '';
$estado = $_POST['estado'] ?? '';

if (!$email || !$id || !is_numeric($estado)) {
    http_response_code(400);
    exit("Dados inválidos.");
}

$bll = new Formacoes_BLL();
$bll->atualizarEstadoFormacao($email, $id, (int)$estado);
$loggerBLL = new LoggerBLL;
$loggerBLL->registarLog($_SESSION['email'], "Atualizou o estado de Formação de $email", "Estado: $estado \nID: $id");

http_response_code(200);
?>