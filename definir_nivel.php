<?php
require_once 'BLL/Listar_Trabalhadores_BLL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $nivel = $_POST['nivel'] ?? null;

    if ($email && $nivel) {
        $bll = new Listar_Trabalhadores_BLL();
        $bll->definirNivel($email, (int)$nivel);
        echo json_encode(['success' => true]);
        exit;
    }
}

echo json_encode(['success' => false]);
?>