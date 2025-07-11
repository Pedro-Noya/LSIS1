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
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="https://unpkg.com/simple-statistics@7.8.8/dist/simple-statistics.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <?php include "cabecalho.php"; ?>

    <div class="filtro-container">
        <form method="GET" class="filtro-form">
            <label for="filtroEquipa">Filtrar por Equipa:</label>
            <select name="filtroEquipa" id="filtroEquipa" onchange="this.form.submit()">
            <option value="todas">Todas as Equipas</option>
            <?php
            $equipas = obterEquipasDoUtilizador();
            foreach ($equipas as $equipa):
            ?>
                <option value="<?= $equipa['nomeEquipa'] ?>" <?= isset($_GET['filtroEquipa']) && $_GET['filtroEquipa'] == $equipa['nomeEquipa'] ? 'selected' : '' ?>>
                <?= $equipa['nomeEquipa'] ?>
                </option>
            <?php endforeach; ?>
            </select>
        </form>
    </div>

    <div class="metricas-container">
    <div id="idadeMedia" class="card-metrica esquerda"></div>
    <div id="tempoMedio" class="card-metrica direita"></div>
    </div>

    <?php showStatistics(); ?>

    <div class="grid-graficos">
        <div class="grafico-miniatura" onclick="abrirModal(1)"><div id="chart1Mini" style="width:100%; height:100%;"></div></div>
        <div class="grafico-miniatura" onclick="abrirModal(2)"><div id="chart2Mini" style="width:100%; height:100%;"></div></div>
        <div class="grafico-miniatura" onclick="abrirModal(3)"><div id="chart3Mini" style="width:100%; height:100%;"></div></div>
        <div class="grafico-miniatura" onclick="abrirModal(4)"><div id="chart4Mini" style="width:100%; height:100%;"></div></div>
        <div class="grafico-miniatura" onclick="abrirModal(5)"><div id="chart5Mini" style="width:100%; height:100%;"></div></div>
    </div>

    <div id="modalGrafico" class="modal">
        <div class="modal-conteudo">
            <span class="fechar" onclick="fecharModal()">&times;</span>
            <div id="chartModalContainer" style="height: 500px; width: 100%;"></div>
        </div>
    </div>
</body>
</html>
