<?php
session_start();
include 'dashboard_dal.php';

function obterEmailColaborador_Coordenador(){
    $dal=new DAL_Dashboard();
    $email="123456@isep.ipp.pt";
    $dados=$dal->obterEmailColaborador_Coordenador($email);
    return $dados;
}

function showStatistics(){
    $dal=new DAL_Dashboard();
    $dadosArray=obterEmailColaborador_Coordenador();
    $arrayDataNascimento=[];
    $arraySexo=[];
    var_dump($dadosArray);
    foreach($dadosArray as $dados){
        $dadosPessoais=$dal->obterDadosColaborador($dados["email"]);
        $arrayDataNascimento[]=$dadosPessoais["dataNascimento"];
        $arraySexo[]=$dadosPessoais["sexo"];
    }

    $arrayIdade=[];
    $dataAtualString=date("Y-m-d");
    foreach($arrayDataNascimento as $dataNascimentoString){
        $dataAtual=date_create($dataAtualString);
        $dataNascimento=date_create($dataNascimentoString);
        /*$idade=date_format($dataAtual, "Y")-date_format($dataNascimento, "Y");
        if(date_format($dataAtual, "m")<date_format($dataNascimento, "m")){
            $idade=$idade-1;
        } else if(date_format($dataAtual, "m")==date_format($dataNascimento, "m")){
            if(date_format($dataAtual, "d")<date_format($dataNascimento, "d")){
                $idade=$idade-1;
            }
        }*/
        $idade = $dataNascimento->diff($dataAtual)->y;
        $arrayIdade[] = $idade;
    }
    print_r($arrayIdade);
    print_r($arraySexo);

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
    echo "Percentagem de Masculino: ",$percentMasculino,"%";
    echo "Percentagem de Feminino: ",$percentFeminino,"%";

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
    }
    </script>";
}
?>