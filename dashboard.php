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
    <style>
    body {
        font-family: 'Montserrat', sans-serif;
        background: #f6f9fc;
        color: #1a3760;
        margin: 0;
        padding: 0;
    }

    h2 {
        color: #0767ea;
        font-weight: 600;
        margin: 10px 20px;
    }

    form {
        background-color: white;
        padding: 10px 20px;
        border-radius: 8px;
        width: fit-content;
        margin-bottom: 20px;
        box-shadow: 0px 2px 8px rgba(0,0,0,0.05);
    }

    select {
        padding: 6px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-family: 'Montserrat', sans-serif;
    }

    .grid-graficos {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .grafico-miniatura {
        background-color: white;
        border-radius: 12px;
        padding: 10px;
        cursor: pointer;
        box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }

    .grafico-miniatura:hover {
        transform: scale(1.02);
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 99;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.6);
        justify-content: center;
        align-items: center;
    }

    .modal-conteudo {
        background-color: white;
        padding: 20px;
        border-radius: 16px;
        max-width: 800px;
        width: 90%;
        box-shadow: 0px 4px 16px rgba(0,0,0,0.2);
    }

    .fechar {
        float: right;
        font-size: 24px;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <?php include "cabecalho.php"; ?>

    <form method="GET" style="margin: 30px;">
        <label for="filtroEquipa">Filtrar por Equipa: </label>
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

    <div id="idadeMedia"></div>
    <div id="tempoMedio"></div>

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
