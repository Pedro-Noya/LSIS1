<?php
include "dashboard_bll.php";
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Portal do Colaborador - Dashboard</title>
        <link href="styles_dashboard.css" rel="stylesheet">
        <!-- Incluir bibliotecas -->
        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
        <script src="https://unpkg.com/simple-statistics@7.8.8/dist/simple-statistics.min.js"></script>
    </head>
    <body>
        <div class="topbar">
            <div class="logo">tlantic</div>
                <nav>
                    <a href="#">sobre nós</a>
                    <a href="#">soluções</a>
                    <a href="#">setores</a>
                    <a href="#">recursos</a>
                    <a href="#">Pesquisar 🔍</a>
                    <a href="#" class="btn-demo">🔔 Pedir uma demo</a>
                    <a href="#" class="btn-experiment">Experimente agora</a>
                    <a href="#">PT ▾</a>
                </nav>
            </div>

            <h1>Portal do Colaborador</h1>

            <div class="tabs">
                <div class="active">Dashboard</div>
                    <div>Info Pessoal</div>
                    <div>Benefícios</div>
                    <div>Férias</div>
                    <div>Formações</div>
                </div>
                <div id="idadeMedia"></div>
                <?php
                showStatistics();
                ?>
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                <br><br>
                <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
                <div class="content">
                    <div class="box">
                        
                    </div>

                    <div class="box">
                        <h2>Demográficas Empresariais</h2>
                        <div class="stats">
                            <div><strong>95</strong><br>Taxa de Retenção</div>
                            <div><strong>2,5</strong><br>Remuneração Média</div>
                        </div>
    </body>
</html>
