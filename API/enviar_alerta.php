<?php
require_once __DIR__ . '/../BLL/Alertas_BLL.php';
require_once __DIR__ . '/../BLL/Logger_BLL.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bll = new Alertas_BLL();

    $tipo = $_POST['tipo'] ?? null;
    $descricao = $_POST['descricao'] ?? null;
    $email = $_POST['email'] ?? null;
    $idAlerta = $_POST['idAlerta'] ?? null;

    $resultado = $bll->enviarAlerta(
        $tipo,
        $descricao,
        $email
    );

    if ($resultado) {
        $bll->atualizardataEmissao(
            $idAlerta,
            date('Y-m-d')
        );
        $loggerBLL = new LoggerBLL();
        $loggerBLL->registarLog($_SESSION['email'], "Enviou um alerta do tipo: $tipo", "Destinatário: $email\nDescrição: $descricao");
        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false]);
        exit();
    }
}
?>