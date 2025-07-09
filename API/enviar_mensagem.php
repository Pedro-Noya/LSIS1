<?php
require_once "../DAL/MensagemEquipa_DAL.php";
session_start();

$nomeEquipa = $_POST['nomeEquipa'] ?? '';
$email = $_SESSION['email'] ?? '';
$mensagem = trim($_POST['mensagem'] ?? '');

if ($nomeEquipa && $email && $mensagem) {
    MensagemEquipa_DAL::enviarMensagem($nomeEquipa, $email, $mensagem);
    header("Location: ../Equipas/equipasInfo.php?nomeEquipa=" . urlencode($nomeEquipa));
    exit;
}
?>