<?php

session_start();

function verificarAcesso(array $perfisPermitidos) {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: /PortalColaborador/login.php");
        exit();
    }

    if (!in_array($_SESSION['papel'], $perfisPermitidos)) {
        header("Location: /PortalColaborador/sem_permissao.php");
        exit();
    }
}

?>