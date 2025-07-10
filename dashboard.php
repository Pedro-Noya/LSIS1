<?php
include "dashboard_bll.php";
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([2,3]);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Portal do Colaborador - Dashboard</title>
    <link href="CSS/dashboard.css" rel="stylesheet">

    <!-- Bibliotecas -->
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="https://unpkg.com/simple-statistics@7.8.8/dist/simple-statistics.min.js"></script>
</head>

<body>
    <?php include "cabecalho.php"; ?>

    <div id="idadeMedia"></div>
    <div id="tempoMedio"></div>

    <?php showStatistics(); ?>

    <!-- Mini-gráficos -->
    <div class="grid-graficos">
        <div class="grafico-miniatura" onclick="abrirModal(1)"><div id="chart1Mini" style="width:100%; height:100%;"></div></div>
        <div class="grafico-miniatura" onclick="abrirModal(2)"><div id="chart2Mini" style="width:100%; height:100%;"></div></div>
        <div class="grafico-miniatura" onclick="abrirModal(3)"><div id="chart3Mini" style="width:100%; height:100%;"></div></div>
        <div class="grafico-miniatura" onclick="abrirModal(4)"><div id="chart4Mini" style="width:100%; height:100%;"></div></div>
        <div class="grafico-miniatura" onclick="abrirModal(5)"><div id="chart5Mini" style="width:100%; height:100%;"></div></div>
    </div>

    <!-- Modal -->
    <div id="modalGrafico" class="modal">
        <div class="modal-conteudo">
            <span class="fechar" onclick="fecharModal()">&times;</span>
            <div id="chartModalContainer" style="height: 500px; width: 100%;"></div>
        </div>
    </div>
</body>
</html>
