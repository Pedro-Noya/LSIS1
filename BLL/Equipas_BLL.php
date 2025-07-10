<?php
require_once __DIR__ . '/../DAL/Equipas_DAL.php';
require_once __DIR__ . '/../DAL/Global_DAL.php';

class Equipa_BLL {
    private $dal;
    private $global_dal;

    public function __construct() {
        $this->dal = new Equipa_DAL();
        $this->global_dal = new Global_DAL();
    }

    public function registarEquipa($nomeEquipa, $dataCriacao) {
        // 1. Verificar se a equipa já existe
        if ($this->dal->obterEquipaPorNome($nomeEquipa)) {
        return "A equipa já existe.";
        }

        // 2. Inserir nova equipa
        $sucesso = $this->dal->criarEquipa($nomeEquipa, $dataCriacao);

        if (!$sucesso) {
        return "Erro ao registar a equipa.";
        }

        return true; 
    }

    public function obterEquipas() {
        return $this->dal->obterEquipas();
    }

    public function obterElementosPorEquipa($nomeEquipa) {
        $elementos = $this->global_dal->obterElementosPorEquipa($nomeEquipa);
        return $elementos;
    }
}
?>
