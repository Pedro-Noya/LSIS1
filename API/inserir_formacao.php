<?php
require_once __DIR__ . "/../BLL/Formacoes_BLL.php";
require_once __DIR__ . "/../BLL/Logger_BLL.php";
require_once __DIR__ . "/../verificar_acesso.php";
verificarAcesso([3,4]);

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || ($_SESSION['papel'] != 3 && $_SESSION['papel'] != 4)) {
    header("Location: ../formacoes.php");
    exit();
}

if (
    empty($_POST['titulo']) || empty($_POST['nivelEnsino']) || empty($_POST['duracao']) ||
    empty($_POST['localizacao']) || empty($_POST['horario']) || !isset($_FILES['imagem'])
) {
    die("Todos os campos são obrigatórios.");
}

$uploadDir = "../Imagens/uploads/";
$publicDir = "Imagens/uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$imagemNome = basename($_FILES['imagem']['name']);
$nomeFinal = time() . "_" . $imagemNome;

$targetPath = $uploadDir . $nomeFinal;       // usado para guardar no disco
$caminhoParaBD = $publicDir . $nomeFinal;    // usado para guardar na base de dados

if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $targetPath)) {
    die("Erro ao guardar a imagem.");
}

// Inserir na base de dados
$formacaoBLL = new Formacoes_BLL();
$formacaoBLL->criarFormacao(
    $_POST['titulo'],
    $caminhoParaBD,
    (int) $_POST['nivelEnsino'],
    (int) $_POST['duracao'],
    $_POST['localizacao'],
    $_POST['horario'],
    $_POST['descricao'] ?? 'Descrição não fornecida'
);
$loggerBLL = new LoggerBLL;
$loggerBLL->registarLog(
    $_SESSION['email'],
    "Criou uma Formação: $idFormacao",
    "Título: {$_POST['titulo']}\n" .
    "Nível de Ensino: {$_POST['nivelEnsino']}\n" .
    "Duração: {$_POST['duracao']}\n" .
    "Localização: {$_POST['localizacao']}\n" .
    "Horário: {$_POST['horario']}\n" .
    "Descrição: {$_POST['descricao']}"
);
header("Location: ../formacoes.php");
exit();
