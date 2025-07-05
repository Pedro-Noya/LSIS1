<?php
require_once __DIR__ . '/../BLL/Alertas_BLL.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bll = new Alertas_BLL();

    $idAlerta = $_POST['idAlerta'] ?? null;

    if ($idAlerta) {
        $resultado = $bll->eliminarAlerta((int)$idAlerta);
        echo json_encode(['success' => $resultado]);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'ID do alerta não fornecido']);
        exit();
    }
}
?>