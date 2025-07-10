<?php
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([3]);

require_once 'BLL/Logger_BLL.php';

$conn = new mysqli('localhost', 'root', '', 'tlantic');
if ($conn->connect_error) {
    die("Erro na ligação à base de dados: " . $conn->connect_error);
}

$voucherId = $_GET['id'] ?? null;
if (!$voucherId) {
    die("Voucher inválido.");
}
//Vamos buscar alguns dados do Voucher em questão de forma a mostrar ao RH algumas informações adicionais
$sql=$conn->prepare("SELECT dataCriacao, voucherNos, descricao, empresa FROM VoucherNos WHERE idVoucherNos=?");
$sql->bind_param("i",$voucherId);
$sql->execute();
$voucherNos=$sql->get_result()->fetch_assoc();

// Processar formulário de submissão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $idVoucherNos=$_POST["idVoucherNos"] ?? null;

    if ($email && $idVoucherNos){

        //Na tabela dos DadosExtrasColaborador, atualizamos o idVoucherNos associado ao email do colaborador que se selecionou
        //no formulário
        $sql=$conn->prepare("UPDATE DadosExtrasColaborador
            SET idVoucherNos = ?
            WHERE email = ?");
        $sql->bind_param("is",$idVoucherNos, $email);
        $sql->execute();

        //Na tabela VoucherNos, altera-se o estado para 1, aonde o idVoucherNos seja aquele que está na variável
        //(que veio da página voucher.php)

        $sql=$conn->prepare("UPDATE VoucherNos SET estado = 1 WHERE idVoucherNos = ?");
        $sql->bind_param("i", $idVoucherNos);
        $sql->execute();

        $loggerBLL = new LoggerBLL();
        $loggerBLL->registarLog($_SESSION['email'], "Atribuiu o voucher NOS de ID: $idVoucherNos ao colaborador: $email");
        header("Location: voucher.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Atribuir Voucher</title>
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

<!-- Modal sempre visível -->
<div class="modal">
  <div class="modal-content">
    <span class="close" onclick="window.history.back()">×</span>
    <h2>Atribuir Voucher</h2>
     <div class="voucher-info">
            <p><strong>Data de Criação:</strong> <?= htmlspecialchars($voucherNos["dataCriacao"]) ?></p>
            <p><strong>Data de Expiração:</strong> <?= htmlspecialchars($voucherNos["voucherNos"]) ?></p>
            <p><strong>Descrição do Voucher:</strong> <?= htmlspecialchars($voucherNos["descricao"]) ?></p>
            <p><strong>Empresa:</strong> <?= htmlspecialchars($voucherNos["empresa"]) ?></p>
        </div>
    <form method="POST">
        <input type="hidden" name="idVoucherNos" value="<?= htmlspecialchars($voucherId) ?>">

        <label for="email">Seleciona o utilizador:</label><br>
        <select name="email" required>
            <option value="" disabled selected>Escolher utilizador</option>
            <?php
                $estado=0;
                $sql = $conn->prepare("
                    SELECT Utilizador.email 
                    FROM Utilizador
                    JOIN DadosExtrasColaborador ON Utilizador.email = DadosExtrasColaborador.email
                    WHERE DadosExtrasColaborador.idVoucherNos IS NULL
                ");
                $sql->execute();
                $colaboradores=$sql->get_result()->fetch_all(MYSQLI_ASSOC);
                foreach($colaboradores as $colaborador){?>
                    <option value="<?= htmlspecialchars($colaborador["email"]) ?>">
                        <?= htmlspecialchars($colaborador["email"]) ?>
                    </option>
                <?php
                }
            ?>
        </select><br><br>

        <button type="submit" class="add-btn">Atribuir</button>
    </form>
  </div>
</div>

</body>
</html>
