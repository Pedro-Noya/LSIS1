<?php
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
        $sql->execute();

        // Redirecionar de volta à página principal
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
