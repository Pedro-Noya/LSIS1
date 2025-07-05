<?php
require_once __DIR__ . '/../BLL/Alertas_BLL.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bll = new Alertas_BLL();

    $idAlerta = $_POST['idAlerta'] ?? null;

    $resultado = $bll->atualizardataEmissao(
        $idAlerta,
        date('Y-m-d')
    );

    if ($resultado) {
        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false]);
        exit();
    }
}
?>