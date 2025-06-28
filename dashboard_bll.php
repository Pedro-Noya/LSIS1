<?php
session_start();
include 'dashboard_dal.php';

function obterEmailColaborador_Coordenador(){
    $dal=new DAL_Dashboard();
    $email=$_SESSION["email"];
    $dados=$dal->obterEmailColaborador_Coordenador($email);
    return $dados;
}

function showStatistics(){
    $dal=new DAL_Dashboard();
    $dadosArray=obterEmailColaborador_Coordenador();
    $arrayDataNascimento=[];
    $arraySexo=[];
    $arrayRenumeracao=[];
    //var_dump($dadosArray);
    foreach($dadosArray as $dados){
        $dadosPessoais=$dal->obterDadosPessoaisColaborador($dados["email"]);
        $dadosFinanceiros=$dal->obterDadosFinanceirosColaborador($dados["email"]);
        $arrayDataNascimento[]=$dadosPessoais["dataNascimento"];
        $arraySexo[]=$dadosPessoais["sexo"];
        $arrayRemuneracao[]=$dadosFinanceiros["remuneracao"];
    }

    $arrayIdade=[];
    $dataAtualString=date("Y-m-d");
    foreach($arrayDataNascimento as $dataNascimentoString){
        $dataAtual=date_create($dataAtualString);
        $dataNascimento=date_create($dataNascimentoString);
        $idade = $dataNascimento->diff($dataAtual)->y;
        $arrayIdade[] = $idade;
    }
    //print_r($arrayIdade);
    //print_r($arraySexo);

    $countSexo=0;
    $countMasculino=0;
    foreach($arraySexo as $sexo){
        if($sexo=="M"){
            $countMasculino++;
        }
        $countSexo++;
    }

    $percentMasculino=($countMasculino/$countSexo)*100;
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

    echo $countEuro;
    echo $countReal;
    echo $countSterling;
    echo $countMetical;


    echo "<script>
    let idades=",json_encode($arrayIdade),"
    let media = ss.mean(idades);
    document.getElementById('idadeMedia').innerHTML='<h2>Idade Média: '+media+'</h2>';

    window.onload = function() {
    var chart=new CanvasJS.Chart('chartContainer', {
	theme: 'light2',
	exportEnabled: true,
	animationEnabled: true,
	title: {
		text: 'Distribuição dos Colaboradores por Género'
	},
    data: [{
		type: 'pie',
		startAngle: 25,
		toolTipContent: '<b>{label}</b>: {y}%',
		showInLegend: 'true',
		legendText: '{label}',
		indexLabelFontSize: 16,
		indexLabel: '{label} - {y}%',
		dataPoints: [
			{ y:",$percentMasculino," , label: 'Masculino' },
			{ y: ",$percentFeminino,", label: 'Feminino' }
		]
	}]
    });
    chart.render();

    var chart2 = new CanvasJS.Chart('chartContainer2', {
	animationEnabled: true,
	theme: 'light2', // 'light1', 'light2', 'dark1', 'dark2'
	title: {
		text: 'Distribuição da Remuneração'
	},
	axisY: {
		title: 'Nº de Colaboradores'
	},
	axisX: {
		title: 'Remuneração'
	},
	data: [{
		type: 'column',
		dataPoints: [
			{ label: 'Euro', y: ",$countEuro," },	
			{ label: 'Real', y: ",$countReal," },	
			{ label: 'Sterling', y: ",$countSterling," },
			{ label: 'Metical', y: ",$countMetical," },			
		]
	}]
    });
    chart2.render();
    }

    var chart3 = new CanvasJS.Chart('chartContainer3', {
	animationEnabled: true,
	theme: 'light2', // 'light1', 'light2', 'dark1', 'dark2'
	title: {
		text: 'Distribuição por Geografia (Localidade)'
	},
	axisY: {
		title: 'Nº de Colaboradores'
	},
	axisX: {
		title: 'Localidade'
	},
	data: [{
		type: 'column',
		dataPoints: [
			{ label: 'Euro', y: ",$countEuro," },	
			{ label: 'Real', y: ",$countReal," },	
			{ label: 'Sterling', y: ",$countSterling," },
			{ label: 'Metical', y: ",$countMetical," },			
		]
	}]
    });
    chart2.render();
    }
    </script>";
}
?>