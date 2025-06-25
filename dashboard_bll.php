<?php
    include "dashboard_dal.php";

    function demograficasNaturais(){
        $idadeMedia=$dal_dashboard->CalcularIdadeMedia();
    }
    <h2>Demográficas Naturais</h2>
                        <div class="stats">
                            <div><strong>33</strong><br>Idade Média</div>
                            <div><strong>2,5</strong><br>Média de Anos<br>na tlantic</div>
                            <div><strong>41</strong><br>% De colab.<br>do sexo feminino</div>
                        </div>
                        <div class="charts">
                            <img src="https://via.placeholder.com/180x180?text=Gráfico+1" alt="Demográficas 1">
                        </div>