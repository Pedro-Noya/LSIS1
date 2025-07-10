<?php
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([2,3]);
require_once 'dashboard_teste_bll.php';

// Carregar dados processados
$data = obterDadosDashboard();
$funcionarios = $data['funcionarios'];
$faixas = $data['faixas'];
$funcoes = $data['funcoes'];
$faixas_genero = $data['faixas_genero'];
$idade_por_funcao = $data['idade_por_funcao'];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Portal do Colaborador – Tlantic</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-box-and-violin-plot/build/Chart.BoxPlot.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>

<header class="main-header">
  <div class="brand">tlantic</div>
  <nav class="top-nav">
    <a href="#">sobre nós</a>
    <a href="#">soluções</a>
    <a href="#">setores</a>
    <a href="#">recursos</a>
    <a href="#">Pesquisar 🔍</a>
    <button class="btn-demo">Pedir uma demo</button>
    <button class="btn-try">Experimente agora</button>
  </nav>
</header>

<!-- Métricas Principais -->
<div class="card demograficas">
  <div class="metricas">
    <div class="metric-box"><div class="valor">26,91</div><div class="descricao">Idade Média</div></div>
    <div class="metric-box"><div class="valor">27,3%</div><div class="descricao">% Feminino</div></div>
    <div class="metric-box"><div class="valor">10a 11m</div><div class="descricao">Média Contrato</div></div>
    <div class="metric-box"><div class="valor">1 173 €</div><div class="descricao">Rem. Média</div></div>
    <div class="metric-box"><div class="valor">36%</div><div class="descricao">Retenção</div></div>
    <div class="metric-box"><div class="valor"><?php echo date("d/m/Y"); ?></div><div class="descricao">Últ. Actual.</div></div>
  </div>

  <!-- Gráficos principais -->
  <div class="charts-area">
    <div class="chart-card"><h3>Nível Hierárquico</h3><canvas id="hierarquiaChart"></canvas></div>
    <div class="chart-card"><h3>Geográfica</h3><canvas id="geoChart"></canvas></div>
    <div class="chart-card"><h3>Nacionalidades</h3>
      <table class="small">
        <thead><tr><th>País</th><th>#</th></tr></thead>
        <tbody>
          <tr><td>Portugal</td><td>8</td></tr>
          <tr><td>Espanha</td><td>2</td></tr>
          <tr><td>Brasil</td><td>1</td></tr>
        </tbody>
      </table>
    </div>
    <div class="chart-card"><h3>Mapa</h3><div id="mapaGeo" class="mapa"></div></div>
    <div class="chart-card full-width"><h3>Colaboradores / Função</h3><canvas id="funcaoChart"></canvas></div>
    <div class="chart-card full-width"><h3>Função por Género</h3><canvas id="funcaoGeneroChart"></canvas></div>
    <div class="chart-card full-width"><h3>Faixa Etária por Género</h3><canvas id="faixaGeneroChart"></canvas></div>
    <div class="chart-card full-width"><h3>Distribuição de Idades por Função (Boxplot)</h3><canvas id="boxplotChart"></canvas></div>
  </div>
</div>

<!-- Tabela Antiguidade -->
<div class="card">
  <h3>Antiguidade por Colaborador</h3>
  <table class="small">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Idade</th>
        <th>Género</th>
        <th>Tempo na Empresa (anos)</th>
        <th>Função</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($funcionarios as $f): ?>
      <tr>
        <td><?php echo htmlspecialchars($f['nome']); ?></td>
        <td><?php echo $f['idade']; ?></td>
        <td><?php echo ucfirst($f['genero']); ?></td>
        <td><?php echo $f['tempo']; ?></td>
        <td><?php echo htmlspecialchars($f['funcao']); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Gráfico Faixas Etárias -->
<div class="card">
  <h3>Distribuição de Idades</h3>
  <canvas id="idadeColaboradores"></canvas>
</div>

<script>
const cores=['#0767ea','#2a9df3','#5aaef7','#7bbbf9'];

function ctx(id){return document.getElementById(id).getContext('2d');}

// Hierarquia, Geográfica, Mapa e outros gráficos
// (mantém as tuas implementações originais aqui)

// Faixas etárias
const faixasLabels = <?php echo json_encode(array_keys($faixas)); ?>;
const faixasValores = <?php echo json_encode(array_values($faixas)); ?>;

new Chart(ctx('idadeColaboradores'), {
  type: 'bar',
  data: {
    labels: faixasLabels,
    datasets: [{
      data: faixasValores,
      backgroundColor: '#39a4f3'
    }]
  },
  options: {
    plugins: { legend: { display: false } },
    responsive: true,
    scales: {
      y: { beginAtZero: true },
      x: { title: { display: true, text: 'Faixa Etária' } }
    }
  }
});

// Função por Género
const funcaoLabels = <?php echo json_encode(array_keys($funcoes)); ?>;
const masculinoFuncao = <?php echo json_encode(array_column($funcoes, 'masculino')); ?>;
const femininoFuncao = <?php echo json_encode(array_column($funcoes, 'feminino')); ?>;

new Chart(ctx('funcaoGeneroChart'), {
  type: 'bar',
  data: {
    labels: funcaoLabels,
    datasets: [
      { label: 'Masculino', data: masculinoFuncao, backgroundColor: '#2a9df3' },
      { label: 'Feminino', data: femininoFuncao, backgroundColor: '#7bbbf9' }
    ]
  },
  options: {
    responsive: true,
    scales: { y: { beginAtZero: true } },
    plugins: { legend: { position: 'top' } }
  }
});

// Faixa Etária por Género
const faixaLabels = <?php echo json_encode(array_keys($faixas_genero)); ?>;
const masculinoFaixa = <?php echo json_encode(array_column($faixas_genero, 'masculino')); ?>;
const femininoFaixa = <?php echo json_encode(array_column($faixas_genero, 'feminino')); ?>;

new Chart(ctx('faixaGeneroChart'), {
  type: 'bar',
  data: {
    labels: faixaLabels,
    datasets: [
      { label: 'Masculino', data: masculinoFaixa, backgroundColor: '#2a9df3' },
      { label: 'Feminino', data: femininoFaixa, backgroundColor: '#7bbbf9' }
    ]
  },
  options: {
    responsive: true,
    scales: { x: { stacked: true }, y: { beginAtZero: true } },
    plugins: { legend: { position: 'top' } }
  }
});

// Boxplot
const boxLabels = <?php echo json_encode(array_keys($idade_por_funcao)); ?>;
const boxData = <?php
$dataBox = [];
foreach ($idade_por_funcao as $idades) {
    sort($idades);
    $min = min($idades);
    $max = max($idades);
    $q1 = $idades[floor(count($idades) * 0.25)];
    $median = $idades[floor(count($idades) * 0.5)];
    $q3 = $idades[floor(count($idades) * 0.75)];
    $dataBox[] = ['min'=>$min,'q1'=>$q1,'median'=>$median,'q3'=>$q3,'max'=>$max];
}
echo json_encode($dataBox);
?>;

new Chart(ctx('boxplotChart'), {
  type: 'boxplot',
  data: {
    labels: boxLabels,
    datasets: [{
      label: 'Idades',
      backgroundColor: '#39a4f3',
      borderColor: '#1a3760',
      borderWidth: 1,
      outlierColor: '#999999',
      padding: 10,
      itemRadius: 0,
      data: boxData
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } }
  }
});
</script>
</body>
</html>