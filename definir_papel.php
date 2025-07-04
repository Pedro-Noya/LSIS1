<?php
require_once 'BLL/Listar_Trabalhadores_BLL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $papel = $_POST['papel'] ?? null;

    if ($email && $papel) {
        $bll = new Listar_Trabalhadores_BLL();
        $bll->definirPapel($email, (int)$papel);
        echo json_encode(['success' => true]);
        exit;
    }
}

echo json_encode(['success' => false]);
?>