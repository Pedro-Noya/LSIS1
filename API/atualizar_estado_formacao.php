<?php
require_once "../BLL/Formacoes_BLL.php";
session_start();

if (!isset($_SESSION['logged_in']) || ($_SESSION['papel'] != 3 && $_SESSION['papel'] != 4)) {
    http_response_code(403);
    exit("Sem permissão.");
}

$email = $_POST['email'] ?? '';
$id = $_POST['idFormacao'] ?? '';
$estado = $_POST['estado'] ?? '';

if (!$email || !$id || !is_numeric($estado)) {
    http_response_code(400);
    exit("Dados inválidos.");
}

$bll = new Formacoes_BLL();
$bll->atualizarEstadoFormacao($email, $id, (int)$estado);

http_response_code(200);
?>