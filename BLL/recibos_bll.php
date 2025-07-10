<?php
include "DAL/recibos_dal.php";

function obterFuncaoRecibos() {
    $dal = new DAL_Recibos();
    return $dal->obterFuncao($_SESSION["email"]);
}

function getRecibosFiltrados() {
    $dal = new DAL_Recibos();
    $papel = obterFuncaoRecibos();
    $emailLogado = $_SESSION["email"];

    if ($papel["papel"] == 3) {
        if (isset($_GET["filtroEmail"]) && $_GET["filtroEmail"] !== "") {
            return $dal->obterRecibosDoUtilizador($_GET["filtroEmail"]);
        } else {
            return $dal->obterTodosRecibos();
        }
    } else {
        return $dal->obterRecibosDoUtilizador($emailLogado);
    }
}

function criarNovoRecibo($nome, $vencimento, $email) {
    $dal = new DAL_Recibos();
    return $dal->inserirRecibo($nome, $vencimento, $email);
}

function getTodosEmailsParaFiltro() {
    $dal = new DAL_Recibos();
    return $dal->obterTodosUtilizadores();
}
