<?php
require_once __DIR__ . '/../DAL/Equipas_Elementos_DAL.php';

class Equipas_Elementos_BLL {
    private $equipaElementosBLL;

    public function __construct() {
        $this->equipaElementosDAL = new Equipa_Elementos_DAL();
    }

    public function adicionarElementoEquipa($nomeEquipa, $emailElemento) {
        if (!$this->equipaElementosDAL->existeEquipa($nomeEquipa)) {
            return "A equipa não existe.";
        }

            $papelElemento = $this->equipaElementosDAL->obterPapelPorEmail($emailElemento);
            if (!$papelElemento) {
                return "O elemento não existe";
            }

        if ($papelElemento !== 1 && $papelElemento !== 2 && $papelElemento !== 3) {
            return "O elemento não pode ser adicionado à equipa, pois não é um colaborador ou coordenador ou RH.";
        }

        $sucesso = $this->equipaElementosDAL->adicionarElemento($nomeEquipa, $emailElemento, "colaboradoresEquipa");

        if (!$sucesso) {
            return "Erro ao adicionar o elemento à equipa.";
        }

        return true;
    }

    public function removerElementoEquipa($nomeEquipa, $emailElemento) {
        if (!$this->equipaElementosDAL->existeEquipa($nomeEquipa)) {
            return "A equipa não existe.";
        }

        $sucesso = $this->equipaElementosDAL->removerElemento($nomeEquipa, $emailElemento);
        if (!$sucesso) {
            return "Erro ao remover o elemento da equipa.";
        }

        return true;
    }

    public function obterEquipaPorNome($nomeEquipa) {

        $resultado = $this->equipaElementosDAL->obterEquipaPorNome($nomeEquipa);
        if (!$resultado) {
            return "A equipa não existe.";
        }
        return $resultado;
    }

    public function permitirAdicionar($nomeEquipa, $emailElemento){
        $resultado=$this->equipaElementosDAL->permitirAdicionar($nomeEquipa, $emailElemento);
        return $resultado;
    }
}

