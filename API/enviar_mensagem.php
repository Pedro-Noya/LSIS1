<?php
require_once __DIR__ . "/../DAL/Mensagem_Equipa_DAL.php";
require_once __DIR__ . "/../BLL/Logger_BLL.php";
require_once __DIR__ . "/../verificar_acesso.php";
verificarAcesso([1,2,3,4]);

$nomeEquipa = $_POST['nomeEquipa'] ?? '';
$email = $_SESSION['email'] ?? '';
$mensagem = trim($_POST['mensagem'] ?? '');
$MensagemEquipa_DAL = new MensagemEquipa_DAL();

if ($nomeEquipa && $email && $mensagem) {
    $MensagemEquipa_DAL->enviarMensagem($nomeEquipa, $email, $mensagem);
    $loggerBLL = new LoggerBLL;
    $loggerBLL->registarLog($email, "Enviou uma mensagem para a Equipa: $nomeEquipa", "Mensagem: $mensagem");
    header("Location: ../Equipas/equipasInfo.php?nome=" . urlencode($nomeEquipa));
    exit;
} else {
    echo "Erro: Não está logado. <br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Nome da Equipa: " . htmlspecialchars($nomeEquipa) . "<br>";
    echo "Mensagem: " . htmlspecialchars($mensagem) . "<br>";
    echo "<a href='/PortalColaborador/login.php'>Por favor, faça login e tente novamente.</a>";
    exit;
}
?>