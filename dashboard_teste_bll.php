<?php
// dashboard_bll.php
// Business Logic Layer - processamento e agregação de dados

require_once 'dashboard_teste_dal.php';

function obterDadosDashboard()
{
    $dal=new DAL_Dashboard();
    $funcionarios = $dal->obterColaboradores();

    // Ordenar por antiguidade
    usort($funcionarios, function($a, $b) {
        return $b['tempo'] - $a['tempo'];
    });

    // Contar faixas etárias
    $faixas = [
        '16-25' => 0,
        '26-35' => 0,
        '36-45' => 0,
        '46+'   => 0
    ];
    foreach ($funcionarios as $f) {
        if ($f['idade'] <= 25) $faixas['16-25']++;
        elseif ($f['idade'] <= 35) $faixas['26-35']++;
        elseif ($f['idade'] <= 45) $faixas['36-45']++;
        else $faixas['46+']++;
    }

    // Função por Género
    $funcoes = [];
    foreach ($funcionarios as $f) {
        if (!isset($funcoes[$f['funcao']])) {
            $funcoes[$f['funcao']] = ['masculino' => 0, 'feminino' => 0];
        }
        $funcoes[$f['funcao']][$f['genero']]++;
    }

    // Faixa Etária por Género
    $faixas_genero = [
        '16-25' => ['masculino' => 0, 'feminino' => 0],
        '26-35' => ['masculino' => 0, 'feminino' => 0],
        '36-45' => ['masculino' => 0, 'feminino' => 0],
        '46+'   => ['masculino' => 0, 'feminino' => 0]
    ];
    foreach ($funcionarios as $f) {
        if ($f['idade'] <= 25) $faixa = '16-25';
        elseif ($f['idade'] <= 35) $faixa = '26-35';
        elseif ($f['idade'] <= 45) $faixa = '36-45';
        else $faixa = '46+';
        $faixas_genero[$faixa][$f['genero']]++;
    }

    // Idade por Função (para o Boxplot)
    $idade_por_funcao = [];
    foreach ($funcionarios as $f) {
        $idade_por_funcao[$f['funcao']][] = $f['idade'];
    }

    return [
        'funcionarios' => $funcionarios,
        'faixas' => $faixas,
        'funcoes' => $funcoes,
        'faixas_genero' => $faixas_genero,
        'idade_por_funcao' => $idade_por_funcao
    ];
}
?>