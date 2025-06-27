<?php
require_once __DIR__ . '/../DAL/Global_DAL.php';

class Global_BLL {
    private $dal;

    public function __construct() {
        // Inicializar a camada de acesso a dados (DAL)
        $this->dal = new Global_DAL();
    }

    public function getUtilizadores() {
        // Método para obter dados globais da aplicação
        return $this->dal->getUtilizadores();
    }

    public function getEquipas() {
        // Método para obter dados das equipas
        return $this->dal->getEquipas();
    }
}
?>