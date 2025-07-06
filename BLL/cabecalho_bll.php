<?php
//session_start();
include __DIR__ . '/../DAL/cabecalho_dal.php';

function mostrarItens(){
    $dal=new DAL_Cabecalho();
    if(isset($_SESSION["email"])){
        $funcao=$dal->determinarFuncao($_SESSION["email"]);
        switch($funcao["papel"]){
            case 1:
                echo "<a href='alertas.php'>Alertas</a>";
                echo "<a href='perfil.php'>Perfil</a>";
                break;
            case 2:
                echo "<a href='dashboard.php'>Dashboard</a>";
                echo "<a href='listar_trabalhadores.php'>Colaboradores</a>";
                echo "<a href='perfil.php'>Perfil</a>";
                break;
            case 3:
                echo "<a href='dashboard.php'>Dashboard</a>";
                echo "<a href='listar_trabalhadores.php'>Colaboradores</a>";
                echo "<a href='perfil.php'>Perfil</a>";
                break;
            case 4:
                echo "<a href='dashboard.php'>Dashboard</a>";
                echo "<a href='listar_trabalhadores.php'>Colaboradores</a>";
                echo "<a href='perfil.php'>Perfil</a>";
                break;
            default:
                echo "Ocorreu algum erro! Não estás logado!";
                break;
        }
    } else{
        echo "<a href='login.php'>Login</a>";
    }   
}