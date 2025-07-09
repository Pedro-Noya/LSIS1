<?php
require_once __DIR__ . '/../DAL/Listar_Trabalhadores_DAL.php';
require_once __DIR__ . '/Global_BLL.php';

class Listar_Trabalhadores_BLL {
    private $listarTrabalhadoresDAL;
    private $globalBLL;

    public function __construct() {
        $this->listarTrabalhadoresDAL = new Listar_Trabalhadores_DAL();
        $this->globalBLL = new Global_BLL();
    }

    public function listarTrabalhadores() {
        $utilizadores = $this->globalBLL->getUtilizadores();

        $equipas = $this->globalBLL->getEquipas();

        $colaboradores = array_filter($utilizadores, function($utilizador) {
            return $utilizador['papel'] == 1;
        });

        $coordenadores = array_filter($utilizadores, function($utilizador) {
            return $utilizador['papel'] == 2;
        });

        $recursosHumanos = array_filter($utilizadores, function($utilizador) {
            return $utilizador['papel'] == 3;
        });

        $administradores = array_filter($utilizadores, function($utilizador) {
            return $utilizador['papel'] == 4;
        });
        

        foreach ($equipas as $equipa) {
            $nomeEquipa = $equipa['nomeEquipa'];
            $elementosEquipa = $this->listarTrabalhadoresDAL->obterElementosPorEquipa($nomeEquipa, 'colaboradoresequipa', $utilizadores);
            /*$elementosCoordenadores = $this->listarTrabalhadoresDAL->obterElementosPorEquipa($nomeEquipa, 'ColaboradoresEquipa', $utilizadores);
            
            $elementosEquipa = array_merge($elementosCoordenadores, $elementosColaboradores);*/
            $equipasArray[$nomeEquipa] = $elementosEquipa;
        }

        return [
            'colaboradores' => $colaboradores,
            'coordenadores' => $coordenadores,
            'recursosHumanos' => $recursosHumanos,
            'administradores' => $administradores,
            'equipasArray' => $equipasArray
        ];
    }

    function exportarColaboradoresExcel($email){
        $this->listarTrabalhadoresDAL->exportarColaboradoresExcel($email);
    }
    
    public function definirPapel($email, $papel) {
        if (!in_array($papel, [1, 2, 3, 4])) {
            return "Papel inválido.";
        }

        $sucesso = $this->listarTrabalhadoresDAL->definirPapel($email, $papel);
        
        if (!$sucesso) {
            return "Erro ao atualizar o papel do utilizador.";
        }

        if ($papel == 2) {
            $sucesso = $this->listarTrabalhadoresDAL->verificarTabelaCoordenador($email);
            if (!$sucesso) {
                return "Erro ao verificar a tabela de coordenadores.";
            }
        }

        return true;
    }

    public function definirNivel($email, $nivel) {
        if (!is_numeric($nivel) || $nivel < 1) {
            return "Nível inválido, deve ser um número maior que 0.";
        }

        $sucesso = $this->listarTrabalhadoresDAL->definirNivel($email, $nivel);
        if (!$sucesso) {
            return "Erro ao atualizar o nível hierárquico do utilizador.";
        }
        return true;
    }

    public function getNivel($email) {
        $nivel = $this->listarTrabalhadoresDAL->getNivel($email);
        if ($nivel === null) {
            return "O utilizador não é um coordenador.";
        }
        return $nivel;
    }
}