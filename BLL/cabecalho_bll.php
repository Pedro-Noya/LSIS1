<?php
// session_start();
include __DIR__ . '/../DAL/cabecalho_dal.php';
$base_url = '/PortalColaborador/';

function mostrarItens(){
    global $base_url;
    $dal = new DAL_Cabecalho();
    if(isset($_SESSION["email"])){
        $funcao = $dal->determinarFuncao($_SESSION["email"]);
        switch($funcao["papel"]){
            case 1:
                echo "<a href='{$base_url}perfil.php'>Perfil</a>";
                break;
            case 2:
                echo "<a href='{$base_url}dashboard.php'>Dashboard</a>";
                echo "<a href='{$base_url}listar_trabalhadores.php'>Colaboradores</a>";
                echo "<a href='{$base_url}perfil.php'>Perfil</a>";
                break;
            case 3:
                echo "<a href='{$base_url}registar.php'>Registar Utilizador</a>";
                echo "<a href='{$base_url}Equipas/equipas.php'>Equipas</a>";
                echo "<a href='{$base_url}emitir_alertas.php'>Alertas</a>";
                echo "<a href='{$base_url}dashboard.php'>Dashboard</a>";
                echo "<a href='{$base_url}listar_trabalhadores.php'>Colaboradores</a>";
                echo "<a href='{$base_url}perfil.php'>Perfil</a>";
                break;
            case 4:
                echo "<a href='{$base_url}alertas.php'>Alertas</a>";
                echo "<a href='{$base_url}dashboard.php'>Dashboard</a>";
                echo "<a href='{$base_url}listar_trabalhadores.php'>Colaboradores</a>";
                echo "<a href='{$base_url}perfil.php'>Perfil</a>";
                break;
            default:
                echo "Ocorreu algum erro! Não estás logado!";
                break;
        }
    } else {
        echo "<a href='{$base_url}login.php'>Login</a>";
    }   
}
