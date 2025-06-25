<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Portal do Colaborador - Dashboard</title>
        <link href="styles_dashboard.css" rel="stylesheet">
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

                <div class="content">
                    <div class="box">
                        
                    </div>

                    <div class="box">
                        <h2>Demográficas Empresariais</h2>
                        <div class="stats">
                            <div><strong>95</strong><br>Taxa de Retenção</div>
                            <div><strong>2,5</strong><br>Remuneração Média</div>
                        </div>
                        
<!-- Incluir bibliotecas -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://unpkg.com/simple-statistics@7.7.2/dist/simple-statistics.min.js"></script>

<h2>Estatísticas</h2>

<!-- Filtros -->
<label for="filtroGenero">Filtrar por Género:</label>
<select id="filtroGenero" onchange="atualizarGraficos()">
  <option value="todos">Todos</option>
  <option value="M">Masculino</option>
  <option value="F">Feminino</option>
</select>

<div id="graficoIdade" style="height: 300px; width: 100%;"></div>
<div id="graficoGenero" style="height: 300px; width: 100%; margin-top: 20px;"></div>
<div id="graficoAnosEmpresa" style="height: 300px; width: 100%; margin-top: 20px;"></div>

<script>
// Simulação de dados – substituir por dados reais do PHP via JSON
const colaboradores = [
    { nome: "Ana", idade: 25, genero: "F", anosEmpresa: 2 },
    { nome: "Bruno", idade: 40, genero: "M", anosEmpresa: 6 },
    { nome: "Carlos", idade: 38, genero: "M", anosEmpresa: 4 },
    { nome: "Diana", idade: 29, genero: "F", anosEmpresa: 3 }
];

function atualizarGraficos() {
    const filtro = document.getElementById("filtroGenero").value;
    const filtrados = filtro === "todos" ? colaboradores : colaboradores.filter(c => c.genero === filtro);

    const idades = filtrados.map(c => c.idade);
    const anos = filtrados.map(c => c.anosEmpresa);

    const idadeMedia = ss.mean(idades);
    const desvioIdade = ss.standardDeviation(idades);

    // Gráfico 1 – Idade
    new CanvasJS.Chart("graficoIdade", {
        animationEnabled: true,
        title: { text: `Distribuição de Idades (Média: ${idadeMedia.toFixed(1)})` },
        data: [{
            type: "column",
            dataPoints: filtrados.map(c => ({ label: c.nome, y: c.idade }))
        }]
    }).render();

    // Gráfico 2 – Género
    const totalF = colaboradores.filter(c => c.genero === "F").length;
    const totalM = colaboradores.filter(c => c.genero === "M").length;

    new CanvasJS.Chart("graficoGenero", {
        animationEnabled: true,
        title: { text: "Distribuição por Género" },
        data: [{
            type: "pie",
            dataPoints: [
                { label: "Feminino", y: totalF },
                { label: "Masculino", y: totalM }
            ]
        }]
    }).render();

    // Gráfico 3 – Anos na empresa
    new CanvasJS.Chart("graficoAnosEmpresa", {
        animationEnabled: true,
        title: { text: "Tempo de Empresa (em anos)" },
        data: [{
            type: "bar",
            dataPoints: filtrados.map(c => ({ label: c.nome, y: c.anosEmpresa }))
        }]
    }).render();
}

window.onload = atualizarGraficos;
</script>
