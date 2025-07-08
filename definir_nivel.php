<?php
require_once 'BLL/Listar_Trabalhadores_BLL.php';
require_once 'BLL/Logger_BLL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $nivel = $_POST['nivel'] ?? null;

    if ($email && $nivel) {
        $bll = new Listar_Trabalhadores_BLL();
        $bll->definirNivel($email, (int)$nivel);
        $loggerBLL = new LoggerBLL();
        $loggerBLL->registarLog($_SESSION['email'], "Definiu o nível hierarquico do coordenador $email para $nivel");
        echo json_encode(['success' => true]);
        exit();
    }
}

echo json_encode(['success' => false]);
?>