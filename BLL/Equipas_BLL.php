<?php
require_once __DIR__ . '/../DAL/Equipas_DAL.php';

class Equipa_BLL {
    private $dal;

    public function __construct() {
        $this->dal = new Equipa_DAL();
    }

    public function registarEquipa($nomeEquipa, $localizacao, $dataCriacao) {
        // 1. Verificar se a equipa já existe
        if ($this->dal->obterEquipaPorNome($nomeEquipa)) {
        return "A equipa já existe.";
        }

        // 2. Inserir nova equipa
        $sucesso = $this->dal->criarEquipa($nomeEquipa, $localizacao, $dataCriacao);

        if (!$sucesso) {
        return "Erro ao registar a equipa.";
        }

        return true; // Registo bem-sucedido
    }
}
?>
