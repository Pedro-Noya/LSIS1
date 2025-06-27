<?php
include "BLL/atualizar_perfil_bll.php";
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Portal do Colaborador - Login</title>
  <link rel="stylesheet" href="styles_atualizar_perfil.css">
</head>
<body>
    <h1> Dados pessoais </h1>
    <?php obterDadosPerfil(); ?>