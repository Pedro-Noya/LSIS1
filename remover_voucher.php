<?php
session_start();

require_once 'BLL/Logger_BLL.php';

$conn = new mysqli('localhost', 'root', '', 'tlantic');
if ($conn->connect_error) {
    die("Erro na ligação à base de dados: " . $conn->connect_error);
}

$idVoucherNos = $_GET['id'] ?? null;
if (!$idVoucherNos) {
    die("Voucher inválido.");
}

// Processar submissão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Remover a associação
    $stmt1 = $conn->prepare("UPDATE DadosExtrasColaborador SET idVoucherNos = NULL WHERE idVoucherNos = ?");
    $stmt1->bind_param("i", $idVoucherNos);
    $stmt1->execute();
    
    // Atualizar o estado do voucher
    $stmt2 = $conn->prepare("UPDATE VoucherNos SET estado = 0 WHERE idVoucherNos = ?");
    $stmt2->bind_param("i", $idVoucherNos);
    $stmt2->execute();

    header("Location: voucher.php");
    exit;
}

//Vamos buscar o email e o nome do colaborador que está associado a este voucher.
//Tendo em conta que o email e o nome só podem, neste caso, ser adquiridos em tabelas diferentes, ir-se-ão utilizar duas queries

$sql=$conn->prepare("SELECT email FROM DadosExtrasColaborador WHERE idVoucherNos=?");
$sql->bind_param("i",$idVoucherNos);
$sql->execute();
$colaboradorEmail=$sql->get_result()->fetch_assoc();

$sql=$conn->prepare("SELECT nome FROM Utilizador WHERE email=?");
$sql->bind_param("s",$colaboradorEmail["email"]);
$sql->execute();
$colaboradorNome=$sql->get_result()->fetch_assoc();

//Vamos, também, aproveitar para ir buscar a data de expiração do Voucher NOS, a data de criação, a descrição e a empresa
$sql=$conn->prepare("SELECT dataCriacao, voucherNos, descricao, empresa FROM VoucherNos WHERE idVoucherNos=?");
$sql->bind_param("s",$idVoucherNos);
$sql->execute();
$voucherNos=$sql->get_result()->fetch_assoc();

$loggerBLL = new LoggerBLL();
$email = $colaboradorEmail["email"];
$loggerBLL->registarLog($_SESSION['email'], "Desassociou o voucher NOS do trabalhador $email", "ID do Voucher: $idVoucherNos");
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Remover Voucher</title>
    <link rel="stylesheet" href="CSS/voucher.css">
    <style>
        .modal {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            width: 400px;
        }

        .close {
            float: right;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
</head>
<body>

<div class="modal">
    <div class="modal-content">
        <span class="close" onclick="window.history.back()">×</span>
        <h2>Remover Voucher</h2>
        <div class="voucher-info">
            <p><strong>Voucher associado a:</strong> <?= htmlspecialchars($colaboradorNome["nome"]) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($colaboradorEmail["email"]) ?></p>
            <p><strong>Data de Criação:</strong> <?= htmlspecialchars($voucherNos["dataCriacao"]) ?></p>
            <p><strong>Data de Expiração:</strong> <?= htmlspecialchars($voucherNos["voucherNos"]) ?></p>
            <p><strong>Descrição do Voucher:</strong> <?= htmlspecialchars($voucherNos["descricao"]) ?></p>
            <p><strong>Empresa:</strong> <?= htmlspecialchars($voucherNos["empresa"]) ?></p>
        </div>

        <form method="POST">
            <button type="submit" class="danger-btn">❌ Desassociar Voucher</button>
        </form>
    </div>
</div>

</body>
</html>
