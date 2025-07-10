<?php
require_once 'BLL/Listar_Trabalhadores_BLL.php';
require_once 'BLL/Logger_BLL.php';
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([3]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $papel = $_POST['papel'] ?? null;

    if ($email && $papel) {
        $bll = new Listar_Trabalhadores_BLL();
        $bll->definirPapel($email, (int)$papel);
        $loggerBLL = new LoggerBLL();
        $loggerBLL->registarLog($_SESSION['email'], "Definiu o papel do trabalhador $email para $papel");
        echo json_encode(['success' => true]);
        exit;
    }
}

echo json_encode(['success' => false]);
?>