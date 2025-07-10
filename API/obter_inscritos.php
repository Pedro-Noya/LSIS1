<?php
require_once "../DAL/Formacoes_DAL.php";
require_once "../BLL/Global_BLL.php";
session_start();

if (!isset($_SESSION['logged_in']) || ($_SESSION['papel'] != 3 && $_SESSION['papel'] != 4)) {
    http_response_code(403);
    exit("Sem permissão.");
}

$idFormacao = $_GET['id'] ?? null;
if (!$idFormacao) {
    http_response_code(400);
    exit("ID inválido.");
}

$dal = new Formacoes_DAL();
$global = new Global_BLL();
$inscricoes = $dal->obterInscricoesPorFormacao($idFormacao);

foreach ($inscricoes as &$i) {
    $utilizador = $global->getUtilizadorporEmail($i['email']);
    $i['nome'] = $utilizador['nome'] ?? 'Desconhecido';
}

header('Content-Type: application/json');
echo json_encode($inscricoes);
?>
