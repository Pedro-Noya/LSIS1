<?php
require_once __DIR__ . '/../BLL/Alertas_BLL.php';
require_once __DIR__ . '/../BLL/Logger_BLL.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bll = new Alertas_BLL();

    $idAlerta = $_POST['idAlerta'] ?? null;

    $resultado = $bll->atualizardataEmissao(
        $idAlerta,
        date('Y-m-d')
    );

    if ($resultado) {
        $loggerBLL = new LoggerBLL();
        $loggerBLL->registarLog($_SESSION['email'], "Descartou o alerta de ID: $idAlerta");
        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false]);
        exit();
    }
}
?>