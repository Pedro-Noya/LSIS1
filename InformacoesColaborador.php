<?php
include __DIR__ . "/BLL/InformacoesColaborador_bll.php";
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([2,3]);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Portal do Colaborador - Login</title>
  <link rel="stylesheet" href= "CSS/atualizar_perfil.css">
  <link rel="stylesheet" href= "CSS/global.css">
</head>
<body>
    <?php
    include "cabecalho.php";
    ?>
    <h1> Dados pessoais </h1>
    <?php
    obterDadosPerfil();
    ?>
</body>
</html>

