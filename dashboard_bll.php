<?php
session_start();
include 'dashboard_dal.php';

/*function obterEmailColaborador_Coordenador(){
    $dal=new DAL_Dashboard();*/
    /*$dados=$dal->obterEmailColaborador_Coordenador($email);
    return $dados;
}*/

function obterFuncao(){
    $dal=new DAL_Dashboard();
    $email=$_SESSION["email"];
    $funcao=$dal->obterFuncao($email);
    return $funcao;
}
function showStatistics($papelMax){
    $funcao=obterFuncao();
    switch($funcao["papel"]){
        case 2:
            $colaboradoresEquipa=$dal->obterMembrosEquipa_Coordenador($email);
            break;
        case 3:
            $colaboradoresEquipa=$dal->obterMembrosEquipa_RH($email);
            break;
        default:
            echo "Algo deu erro! ! !";
            break;
    }
    //$dadosArray=obterEmailColaborador_Coordenador();
    $arrayDataNascimento=[];
    $arraySexo=[];
    $arrayRenumeracao=[];
    $arrayNacionalidade=[];
    foreach($colaboradoresEquipa as $colaborador){
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
    //print_r($arrayIdade);
    //print_r($arraySexo);

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

    echo "<script>
    let idades=",json_encode($arrayIdade),";
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
			{ label: 'Metical', y: ",$countMetical," }		
		]
	}]
    });
    chart2.render();

    var chart3 = new CanvasJS.Chart('chartContainer3', {
	animationEnabled: true,
	theme: 'light2', // 'light1', 'light2', 'dark1', 'dark2'
	title: {
		text: 'Distribuição da Nacionalidade'
	},
	axisY: {
		title: 'Nº de Colaboradores'
	},
	axisX: {
		title: 'Nacionalidade'
	},
	data: [{
		type: 'column',
		dataPoints: [
			{ label: 'Andorra', y: ",$countAndorra," },
			{ label: 'Espanha', y: ",$countEspanha," },
			{ label: 'Portugal', y: ",$countPortugal," },
			{ label: 'Moçambique', y: ",$countMocambique," },
            { label: 'Brasil', y: ",$countBrasil," },
            { label: 'Reino Unido', y: ",$countReinoUnido," }
		]
	}]
    });
    chart3.render();
    }
    </script>";
}
?>