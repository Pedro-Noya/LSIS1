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
        <?php include "cabecalho.php"; ?>
            <div class="tabs">
                <div id="idadeMedia"></div>
            <?php
                showStatistics();
            ?>
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            <br><br>
            <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
            <br><br>
            <div id="chartContainer3" style="height: 370px; width: 100%;"></div>

            <div class="content">
                <div class="box">
                    
                </div>
            </div>
    </body>
</html>
