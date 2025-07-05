<?php
require_once __DIR__ . '/../BLL/Alertas_BLL.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bll = new Alertas_BLL();

    $tipo = $_POST['tipo'] ?? null;
    $descricao = $_POST['descricao'] ?? null;
    $email = $_POST['email'] ?? null;
    $periodicidade = $_POST['periodicidade'] ?? null;

    $idAlerta = $bll->existeAlerta(
        $tipo,
        $email,
        (int)$periodicidade,
        $descricao
    );

    if ($idAlerta) {
        echo json_encode(['success' => true, 'idAlerta' => $idAlerta]);
        exit();
    } else {
        echo json_encode(['success' => false, 'idAlerta' => null]);
        exit();
    }
}
?>