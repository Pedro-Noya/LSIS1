<?php
require_once __DIR__ . '/../DAL/Alertas_DAL.php';
require_once __DIR__ . '/../BLL/Global_BLL.php';

class Alertas_BLL {
    private $bll;

    public function __construct() {
        $this->dal = new Alertas_DAL();
    }

    public function listarAlertas() {
        return $this->dal->listarAlertas();
    }

    public function cadastrarAlerta($tipo, $descricao, $periodicidade, $email, $data) {
        return $this->dal->cadastrarAlerta($tipo, $descricao, $periodicidade, $email, $data);
    }

    public function enviarAlerta($tipo, $descricao, $email) {
        enviarEmailAlerta($email, $tipo, $descricao);
    }
}

?>