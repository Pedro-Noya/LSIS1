<?php
include "perfil_bll.php";
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([1,2,3,4]);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Portal do Colaborador - Login</title>
  <link rel="stylesheet" href="CSS/atualizar_perfil.css">
</head>
<body>
  <?php include "cabecalho.php"; ?>
  <div class="titulo-pagina">
    <h1>Dados pessoais</h1>
  </div>
  <?php obterDadosPerfil();?>
</body>
</html>