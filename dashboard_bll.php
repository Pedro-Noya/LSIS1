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

    echo "<script>window.onload = function() {
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
	exportEnabled: true,
	theme: 'light1',
	title:{
		text: 'Distribuição da Remuneração'
	},
  	axisY: {
      includeZero: true
    },
	data: [{
		type: 'column', //change type to bar, line, area, pie, etc
		//indexLabel: '{y}', //Shows y value on all Data Points
		indexLabelFontColor: '#5A5757',
      	indexLabelFontSize: 16,
		indexLabelPlacement: 'outside',
		dataPoints: [
			{ x: 1, y: ",$countEuro,"},
			{ x: 2, y: ",$countReal,"},
			{ x: 3, y: ",$countSterling,"},
			{ x: 4, y: ",$countMetical,"}
	    ]
	}]
    });
    chart2.render();
    }
    </script>";
}
?>