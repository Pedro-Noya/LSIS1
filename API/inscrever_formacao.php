<?php
require_once __DIR__ . "/../DAL/Formacoes_DAL.php";
require_once __DIR__ . "/../BLL/Pedido_BLL.php";
require_once __DIR__ . '/../BLL/Logger_BLL.php';
require_once __DIR__ . "/../verificar_acesso.php";
verificarAcesso([1,2,3,4]);


$email = $_SESSION['email'];
$idFormacao = $_POST['idFormacao'] ?? null;

if (!$idFormacao) {
    die("ID de formação em falta.");
}

$dal = new Formacoes_DAL();
$jaInscrito = $dal->verificarInscricao($email, $idFormacao);

if ($jaInscrito) {
    header("Location: ../formacoes.php");
    exit();
}

$dal->inscreverColaborador($email, $idFormacao);

$bll = new PedidoBLL();
$bll->registarPedido(
    $email,
    "Inscrição em Formação",
    "Inscrição na formação com ID: $idFormacao",
    NULL,
    "Formação ID: $idFormacao"
);
$loggerBLL = new LoggerBLL;
$loggerBLL->registarLog($_SESSION['email'], "Inscreveu-se na Formação: $idFormacao");
header("Location: ../formacoes.php?msg=inscrito");
exit();
?>