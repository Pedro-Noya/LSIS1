<?php
session_start();
include 'dashboard_dal.php';

function obterDadosColaborador(){
    $dal=new DAL_Dashboard();
    $dados=$dal->obterDadosColaborador();
}

function showStatistics(){

}
?>