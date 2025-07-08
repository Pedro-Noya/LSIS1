<?php
require_once __DIR__ . '/../DAL/Logger_DAL.php';

class LoggerBLL {
    private $dal;

    public function __construct() {
        $this->dal = new LoggerDAL();
    }

    public function registarLog($email, $acao, $detalhes = "Não existe mais Informação") {
        return $this->dal->registarLog($email, $acao, $detalhes);
    }

    public function obterLogs() {
        return $this->dal->obterLogs();
    }
}
?>