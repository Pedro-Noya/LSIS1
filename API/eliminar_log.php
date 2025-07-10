<?php
require_once __DIR__ . '/../BLL/Logger_BLL.php';
require_once __DIR__ . "/../verificar_acesso.php";
verificarAcesso([4]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idLog'])) {
    $idLog = (int)$_POST['idLog'];
    $logger = new LoggerBLL();
    $logger->removerLog($idLog);
}

header('Location: ../listar_logs.php');
exit();
?>