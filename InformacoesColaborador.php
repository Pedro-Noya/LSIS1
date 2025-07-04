<?php
include __DIR__ . "/BLL/InformacoesColaborador_bll.php";
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Portal do Colaborador - Login</title>
  <link rel="stylesheet" href= "CSS/atualizar_perfil.css">
</head>
<body>
    <h1> Dados pessoais </h1>
    <?php obterDadosPerfil();?>
</body>
</html>

