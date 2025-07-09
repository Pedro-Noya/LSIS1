<?php
session_start();

require_once 'BLL/Logger_BLL.php';

$conn = new mysqli('localhost', 'root', '', 'tlantic');
if ($conn->connect_error) {
    die("Erro na ligação à base de dados: " . $conn->connect_error);
}

// Verifica se veio do botão de criação
if (isset($_POST['voucherNos']) && isset($_POST["empresa"]) && isset($_POST["descricao"])) {
    $dataCriacao=date("Y-m-d");
    $voucherNos = $_POST['voucherNos'] ?? null;
    $empresa = $_POST["empresa"] ?? null;
    $descricao = $_POST["descricao"] ?? null;
    $dataMinima = date('Y-m-d', strtotime('+6 months'));
    echo "<script>
        alert('A data mínima é: {$dataMinima}');
    </script>";

    if ($voucherNos < $dataMinima) {
        echo "<script>
            alert('A data de expiração deve ser pelo menos 6 meses superior à data atual.');
            window.location.href='voucher.php';
        </script>";
        exit;
    }

    if ($voucherNos && $empresa && $descricao) {
        // Inserir o novo voucher
        $sql = $conn->prepare("INSERT INTO VoucherNos (dataCriacao, voucherNos, descricao, empresa, estado) VALUES (?, ?, ?, ?, 0)");
        $sql->bind_param("ssss", $dataCriacao, $voucherNos, $descricao, $empresa);
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
