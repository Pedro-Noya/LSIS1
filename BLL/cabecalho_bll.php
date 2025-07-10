<?php
include __DIR__ . '/../DAL/cabecalho_dal.php';
$base_url = '/PortalColaborador/';

function mostrarItens(){
    global $base_url;
    $dal = new DAL_Cabecalho();
    if(isset($_SESSION["email"])){
        $funcao = $dal->determinarFuncao($_SESSION["email"]);
        switch($funcao["papel"]){
            case 1:
                echo "<a href='{$base_url}pedidos.php'>Pedidos</a>";
                echo "<a href='{$base_url}Equipas/equipasInfo.php'>Equipas</a>";
                break;
            case 2:
                echo "<a href='{$base_url}pedidos.php'>Pedidos</a>";
                echo "<a href='{$base_url}dashboard.php'>Dashboard</a>";
                echo "<a href='{$base_url}Equipas/equipasInfo.php'>Equipas</a>";    
                break;
            case 3:
                echo "<a href='{$base_url}registar.php'>Registar Utilizador</a>";
                    echo "
                    <div class='dropdown-container'>
                        <a href='#' class='dropdown-toggle' onclick='toggleDropdown(event, this)'>
                            <span class='dropdown-label'>Equipas ▼</span>
                        </a>
                        <ul class='dropdown-menu'>
                            <li><a href='{$base_url}Equipas/equipas.php'>Criar Equipa</a></li>
                            <li><a href='{$base_url}Equipas/equipaselementos.php'>Gerir Equipas</a></li>
                            <li><a href='{$base_url}Equipas/equipasinfo.php'>Ver Equipas</a></li>
                        </ul>
                    </div>
                    ";
                echo "<a href='{$base_url}emitir_alertas.php'>Alertas</a>";
                echo "<a href='{$base_url}dashboard.php'>Dashboard</a>";
                echo "<a href='{$base_url}listar_trabalhadores.php'>Trabalhadores</a>";
                echo "<a href='{$base_url}voucher.php'>Vouchers</a>";
                echo "<a href='{$base_url}listar_pedidos.php'>Pedidos</a>"; 
                break;
            case 4:
                echo "<a href='{$base_url}listar_logs.php'>Logs</a>";
                echo "<a href='{$base_url}alertas.php'>Alertas</a>";
                echo "<a href='{$base_url}dashboard.php'>Dashboard</a>";
                echo "<a href='{$base_url}listar_trabalhadores.php'>Colaboradores</a>";
                echo "<a href='{$base_url}Equipas/equipasInfo.php'>Equipas</a>";
                break;
            default:
                echo "Ocorreu algum erro! Não estás logado!";
                break;
        }
        echo "<a href='{$base_url}formacoes.php'>Formações</a>";
        echo "<a href='{$base_url}perfil.php'>Perfil</a>";
        echo "<a href='{$base_url}logout.php'>Sair</a>";
    } else {
        echo "<a href='{$base_url}login.php'>Login</a>";
    }   
}
?>
