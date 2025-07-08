<?php
session_start();

require_once 'BLL/Logger_BLL.php';

$conn = new mysqli('localhost', 'root', '', 'tlantic');
if ($conn->connect_error) {
    die("Erro na ligação à base de dados: " . $conn->connect_error);
}

// Verifica se veio do botão de criação
if (isset($_POST['voucherNos'])) {
    $voucherNos = $_POST['voucherNos'] ?? null;

    if ($voucherNos) {
        // Inserir o novo voucher
        $sql = $conn->prepare("INSERT INTO VoucherNos (voucherNos, estado) VALUES (?, 0)");
        $sql->bind_param("s", $voucherNos);
        $id = $conn->insert_id;
        $sql->execute();

        // Redirecionar de volta à página principal
        $loggerBLL = new LoggerBLL();
        $loggerBLL->registarLog($_SESSION['email'], "Criou um novo voucher NOS: $id", "Data de Expiração: $voucherNos");
        header("Location: voucher.php");
        exit;
    } else {
        die("Data inválida.");
    }
} else {
    // Se alguém aceder diretamente
    header("Location: voucher.php");
    exit;
}
?>
