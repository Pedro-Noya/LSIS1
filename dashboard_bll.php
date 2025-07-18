<?php
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([2,3]);
include 'dashboard_dal.php';

/*function obterEmailColaborador_Coordenador(){
    $dal=new DAL_Dashboard();*/
    /*$dados=$dal->obterEmailColaborador_Coordenador($email);
    return $dados;
}*/

function obterEquipasDoUtilizador() {
    $dal = new DAL_Dashboard();
    $email = $_SESSION["email"];
    return $dal->obterEquipasDoUtilizador($email);
}
function obterFuncao(){
    $dal=new DAL_Dashboard();
    $email=$_SESSION["email"];
    $funcao=$dal->obterFuncao($email);
    return $funcao;
}
function showStatistics(){
    $dal=new DAL_Dashboard();
    $email=$_SESSION["email"];
    $papel=obterFuncao();

    $filtroEquipa = $_GET['filtroEquipa'] ?? 'todas';
    $colaboradoresEquipa = [];

    switch ($papel["papel"]) {
        case 2: // Coordenador
            if ($filtroEquipa == 'todas') {
                $colaboradoresEquipa = $dal->obterMembrosEquipa_Coordenador($email);
            } else {
                $colaboradoresEquipa = $dal->obterMembrosDeUmaEquipaFiltrada($filtroEquipa, 2);
            }
            break;
        case 3: // RH
            if ($filtroEquipa == 'todas') {
                $colaboradoresEquipa = $dal->obterMembrosEquipa_RH($email);
            } else {
                $colaboradoresEquipa = $dal->obterMembrosDeUmaEquipaFiltrada($filtroEquipa, 3);
            }
            break;
        default:
            echo "Algo deu erro!";
            return;
    }

    //$dadosArray=obterEmailColaborador_Coordenador();
    $arrayDataNascimento=[];
    $arraySexo=[];
    $arrayRenumeracao=[];
    $arrayNacionalidade=[];
    $arrayDataCriacao=[];

    $colaboradoresNaoRetidos=0;
    $colaboradoresRetidos=0;
    $colaboradoresTotais=0;

    $numColaboradores=0;
    $numCoordenadores=0;
    $numRH=0;

    foreach($colaboradoresEquipa as $colaborador){
        $privado=$dal->obterDadosPrivadosColaborador($colaborador["email"]);

        //Para a taxa de retenção
        if($privado["estado"]!=3){ //Quer dizer que o Colaborador ainda está mantido na Empresa
            $colaboradoresRetidos++;
        } else{
            $colaboradoresNaoRetidos++;
        }
        $colaboradoresTotais++;

        //Para a distribuição da função
        switch($privado["papel"]){
            case 1:
                $numColaboradores++;
                break;
            case 2:
                $numCoordenadores++;
                break;
            case 3:
                $numRH++;
                break;
            default:
                break;
        }

        //Para o tempo na tlantic
        $arrayDataCriacao[]=$privado["dataCriacao"];

        $dadosPessoais=$dal->obterDadosPessoaisColaborador($colaborador["email"]);
        if(!($dadosPessoais==null)){
            $arrayDataNascimento[]=$dadosPessoais["dataNascimento"];
            $arraySexo[]=$dadosPessoais["sexo"];
            $arrayNacionalidade[]=$dadosPessoais["nacionalidade"];
        }
        $dadosFinanceiros=$dal->obterDadosFinanceirosColaborador($colaborador["email"]);
        if(!($dadosFinanceiros==null)){
            $arrayRemuneracao[]=$dadosFinanceiros["remuneracao"];
        }
    }

    $arrayIdade=[];
    $dataAtualString=date("Y-m-d");
    foreach($arrayDataNascimento as $dataNascimentoString){
        $dataAtual=date_create($dataAtualString);
        $dataNascimento=date_create($dataNascimentoString);
        $idade = $dataNascimento->diff($dataAtual)->y;
        $arrayIdade[] = $idade;
    }

    $arrayTempo=[];
    foreach($arrayDataCriacao as $dataCriacaoString){
        $dataAtual=date_create($dataAtualString);
        $dataCriacao=date_create($dataCriacaoString);
        $tempo = $dataCriacao->diff($dataAtual)->y;
        $arrayTempo[] = $tempo;
    }

    $countMasculino=0;
    $countFeminino=0;
    foreach($arraySexo as $sexo){
        if($sexo=="M"){
            $countMasculino++;
        } else if($sexo=="F"){
            $countFeminino++;
        }
    }

    $percentMasculino=($countMasculino/($countMasculino+$countFeminino))*100;
    $percentFeminino=100-$percentMasculino;

    $countRemuneracao=count($arrayRemuneracao);
    $countEuro=0;
    $countReal=0;
    $countSterling=0;
    foreach($arrayRemuneracao as $remuneracao){
        if($remuneracao=="Euro"){
            $countEuro++;
        }
        if($remuneracao=="Real"){
            $countReal++;
        }
        if($remuneracao=="Sterling"){
            $countSterling++;
        }
    }
    $countMetical=$countRemuneracao-($countEuro+$countReal+$countSterling);

    $countNacionalidade=count($arrayNacionalidade);
    $countAndorra=0;
    $countEspanha=0;
    $countPortugal=0;
    $countMocambique=0;
    $countBrasil=0;
    $countReinoUnido=0;

    foreach($arrayNacionalidade as $nacionalidade){
        if($nacionalidade=="Andorra"){
            $countAndorra++;
        }
        if($nacionalidade=="Espanha"){
            $countEspanha++;
        }
        if($nacionalidade=="Portugal"){
            $countPortugal++;
        }
        if($nacionalidade=="Mocambique"){
            $countMocambique++;
        }
        if($nacionalidade=="Brasil"){
            $countBrasil++;
        }
    }
    $countReinoUnido=$countNacionalidade-$countAndorra-$countEspanha-$countPortugal-$countMocambique-$countBrasil;

    $arrayFuncao=["Colaborador","Coordenador","RH","Administrador"];

    $percentRetidos=($colaboradoresRetidos/$colaboradoresTotais)*100;
    $percentNaoRetidos=100-$percentRetidos;

    echo '<script>
    let idades = ' . json_encode($arrayIdade) . ';
    let tempos = ' . json_encode($arrayTempo) . ';
    let media = ss.mean(idades);
    let mediaTempo = ss.mean(tempos);
    document.getElementById("idadeMedia").innerHTML = "<h2>Idade Média: " + media.toFixed(1) + "</h2>";
    document.getElementById("tempoMedio").innerHTML = "<h2>Tempo Médio na Tlantic (em anos): " + mediaTempo.toFixed(1) + "</h2>";

    window.onload = function() {
        new CanvasJS.Chart("chart1Mini", {
            theme: "light2",
            backgroundColor: "#ffffff",
            title: {
                text: "Distribuição por Género",
                fontFamily: "Montserrat",
                fontColor: "#0767ea",
                fontSize: 16
            },
            legend: {
                fontFamily: "Montserrat",
                fontColor: "#1a3760"
            },
            data: [{
                type: "pie",
                indexLabelFontFamily: "Montserrat",
                indexLabelFontColor: "#1a3760",
                dataPoints: [
                    { label: "Masculino", y: ' . $percentMasculino . ', color: "#0767ea" },
                    { label: "Feminino", y: ' . $percentFeminino . ', color: "#2a9df3" }
                ]
            }]
        }).render();

        new CanvasJS.Chart("chart2Mini", {
            theme: "light2",
            backgroundColor: "#ffffff",
            title: {
                text: "Distribuição da Remuneração",
                fontFamily: "Montserrat",
                fontColor: "#0767ea",
                fontSize: 16
            },
            axisY: {
                title: "Colaboradores",
                labelFontFamily: "Montserrat",
                labelFontColor: "#1a3760",
                gridColor: "#dfeaf2",
                lineColor: "#2a9df3"
            },
            axisX: {
                labelFontFamily: "Montserrat",
                labelFontColor: "#1a3760",
                lineColor: "#2a9df3"
            },
            data: [{
                type: "column",
                color: "#2a9df3",
                dataPoints: [
                { label: "Euro", y: ' . $countEuro . ' },
                { label: "Real", y: ' . $countReal . ' },
                { label: "Sterling", y: ' . $countSterling . ' },
                { label: "Metical", y: ' . $countMetical . ' }
                ]
            }]
        }).render();

        new CanvasJS.Chart("chart3Mini", {
            theme: "light2",
            backgroundColor: "#ffffff",
            title: {
                text: "Distribuição da Nacionalidade",
                fontFamily: "Montserrat",
                fontColor: "#0767ea",
                fontSize: 16
            },
            axisY: {
                title: "Nº de Colaboradores",
                labelFontFamily: "Montserrat",
                labelFontColor: "#1a3760",
                gridColor: "#dfeaf2",
                lineColor: "#2a9df3"
            },
            axisX: {
                title: "Nacionalidade",
                labelFontFamily: "Montserrat",
                labelFontColor: "#1a3760",
                lineColor: "#2a9df3"
            },
            data: [{
                type: "column",
                color: "#2a9df3",
                dataPoints: [
                { label: "Andorra", y: ' . $countAndorra . ' },
                { label: "Espanha", y: ' . $countEspanha . ' },
                { label: "Portugal", y: ' . $countPortugal . ' },
                { label: "Moçambique", y: ' . $countMocambique . ' },
                { label: "Brasil", y: ' . $countBrasil . ' },
                { label: "Reino Unido", y: ' . $countReinoUnido . ' }
                ]
            }]
        }).render();

        new CanvasJS.Chart("chart4Mini", {
            theme: "light2",
            backgroundColor: "#ffffff",
            title: {
                text: "Taxa de Retenção",
                fontFamily: "Montserrat",
                fontColor: "#0767ea",
                fontSize: 16
            },
            legend: {
                fontFamily: "Montserrat",
                fontColor: "#1a3760"
            },
            data: [{
                type: "pie",
                indexLabelFontFamily: "Montserrat",
                indexLabelFontColor: "#1a3760",
                indexLabel: "{label} - {y.toFixed(1)}%",
                dataPoints: [
                { label: "Colaboradores retidos", y: ' . $percentRetidos . ', color: "#2a9df3" },
                { label: "Colaboradores não retidos", y: ' . $percentNaoRetidos . ', color: "#0767ea" }
                ]
            }]
        }).render();

        new CanvasJS.Chart("chart5Mini", {
            theme: "light2",
            backgroundColor: "#ffffff",
            title: {
                text: "Distribuição por Função",
                fontFamily: "Montserrat",
                fontColor: "#0767ea",
                fontSize: 16
            },
            axisY: {
                title: "Nº de Colaboradores",
                labelFontFamily: "Montserrat",
                labelFontColor: "#1a3760",
                gridColor: "#dfeaf2",
                lineColor: "#2a9df3"
            },
            axisX: {
                title: "Função",
                labelFontFamily: "Montserrat",
                labelFontColor: "#1a3760",
                lineColor: "#2a9df3"
            },
            data: [{
                type: "column",
                color: "#2a9df3",
                dataPoints: [
                { label: "Colaborador", y: ' . $numColaboradores . ' },
                { label: "Coordenador", y: ' . $numCoordenadores . ' },
                { label: "RH", y: ' . $numRH . ' }
                ]
            }]
        }).render();
    }

    function abrirModal(id) {
        document.getElementById("modalGrafico").style.display = "block";

        let chart;
        switch(id){
            case 1:
                chart = new CanvasJS.Chart("chartModalContainer", {
                    theme: "light2",
                    backgroundColor: "#ffffff",
                    title: {
                        text: "Distribuição por Género",
                        fontFamily: "Montserrat",
                        fontColor: "#0767ea",
                        fontSize: 16
                    },
                    legend: {
                        fontFamily: "Montserrat",
                        fontColor: "#1a3760"
                    },
                    data: [{
                        type: "pie",
                        indexLabelFontFamily: "Montserrat",
                        indexLabelFontColor: "#1a3760",
                        dataPoints: [
                            { label: "Masculino", y: ' . $percentMasculino . ', color: "#0767ea" },
                            { label: "Feminino", y: ' . $percentFeminino . ', color: "#2a9df3" }
                        ]
                    }]
                });
                break;
            case 2:
                chart = new CanvasJS.Chart("chartModalContainer", {
                    theme: "light2",
                    backgroundColor: "#ffffff",
                    title: {
                        text: "Distribuição da Remuneração",
                        fontFamily: "Montserrat",
                        fontColor: "#0767ea",
                        fontSize: 16
                    },
                    axisY: {
                        title: "Colaboradores",
                        labelFontFamily: "Montserrat",
                        labelFontColor: "#1a3760",
                        gridColor: "#dfeaf2",
                        lineColor: "#2a9df3"
                    },
                    axisX: {
                        labelFontFamily: "Montserrat",
                        labelFontColor: "#1a3760",
                        lineColor: "#2a9df3"
                    },
                    data: [{
                        type: "column",
                        color: "#2a9df3",
                        dataPoints: [
                        { label: "Euro", y: ' . $countEuro . ' },
                        { label: "Real", y: ' . $countReal . ' },
                        { label: "Sterling", y: ' . $countSterling . ' },
                        { label: "Metical", y: ' . $countMetical . ' }
                        ]
                    }]
                });
                break;
            case 3:
                chart = new CanvasJS.Chart("chartModalContainer", {
                    theme: "light2",
                    backgroundColor: "#ffffff",
                    title: {
                        text: "Distribuição da Nacionalidade",
                        fontFamily: "Montserrat",
                        fontColor: "#0767ea",
                        fontSize: 16
                    },
                    axisY: {
                        title: "Nº de Colaboradores",
                        labelFontFamily: "Montserrat",
                        labelFontColor: "#1a3760",
                        gridColor: "#dfeaf2",
                        lineColor: "#2a9df3"
                    },
                    axisX: {
                        title: "Nacionalidade",
                        labelFontFamily: "Montserrat",
                        labelFontColor: "#1a3760",
                        lineColor: "#2a9df3"
                    },
                    data: [{
                        type: "column",
                        color: "#2a9df3",
                        dataPoints: [
                        { label: "Andorra", y: ' . $countAndorra . ' },
                        { label: "Espanha", y: ' . $countEspanha . ' },
                        { label: "Portugal", y: ' . $countPortugal . ' },
                        { label: "Moçambique", y: ' . $countMocambique . ' },
                        { label: "Brasil", y: ' . $countBrasil . ' },
                        { label: "Reino Unido", y: ' . $countReinoUnido . ' }
                        ]
                    }]
                });
                break;
            case 4:
                chart = new CanvasJS.Chart("chartModalContainer", {
                    theme: "light2",
                    backgroundColor: "#ffffff",
                    title: {
                        text: "Taxa de Retenção",
                        fontFamily: "Montserrat",
                        fontColor: "#0767ea",
                        fontSize: 16
                    },
                    legend: {
                        fontFamily: "Montserrat",
                        fontColor: "#1a3760"
                    },
                    data: [{
                        type: "pie",
                        indexLabelFontFamily: "Montserrat",
                        indexLabelFontColor: "#1a3760",
                        indexLabel: "{label} - {y.toFixed(1)}%",
                        dataPoints: [
                        { label: "Colaboradores retidos", y: ' . $percentRetidos . ', color: "#2a9df3" },
                        { label: "Colaboradores não retidos", y: ' . $percentNaoRetidos . ', color: "#0767ea" }
                        ]
                    }]
                });
                break;
            case 5:
                chart = new CanvasJS.Chart("chartModalContainer", {
                    theme: "light2",
                    backgroundColor: "#ffffff",
                    title: {
                        text: "Distribuição por Função",
                        fontFamily: "Montserrat",
                        fontColor: "#0767ea",
                        fontSize: 16
                    },
                    axisY: {
                        title: "Nº de Colaboradores",
                        labelFontFamily: "Montserrat",
                        labelFontColor: "#1a3760",
                        gridColor: "#dfeaf2",
                        lineColor: "#2a9df3"
                    },
                    axisX: {
                        title: "Função",
                        labelFontFamily: "Montserrat",
                        labelFontColor: "#1a3760",
                        lineColor: "#2a9df3"
                    },
                    data: [{
                        type: "column",
                        color: "#2a9df3",
                        dataPoints: [
                        { label: "Colaborador", y: ' . $numColaboradores . ' },
                        { label: "Coordenador", y: ' . $numCoordenadores . ' },
                        { label: "RH", y: ' . $numRH . ' }
                        ]
                    }]
                });
                break;
        }
        chart.render();
    }

    function fecharModal() {
        document.getElementById("modalGrafico").style.display = "none";
    }
</script>';

}
?>