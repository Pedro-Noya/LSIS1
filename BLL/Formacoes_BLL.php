<?php
require_once __DIR__ . '/../DAL/Formacoes_DAL.php';

class Formacoes_BLL {
    private $dal;

    function __construct() {
        $this->dal = new Formacoes_DAL();
    }

    public function obterFormacoes() {
        return $this->dal->listarTodas();
    }

    public function obterFormacaoPorId($id) {
        return $this->dal->listarPorId($id);
    }

    public function criarFormacao($titulo, $imagemPath, $nivelEnsino, $duracao, $localizacao, $horario, $descricao = 'Descrição não fornecida') {
        return $this->dal->criarFormacao($titulo, $imagemPath, (int) $nivelEnsino, (int) $duracao, $localizacao, $horario, $descricao);
    }

    public function inscreverColaborador($email, $idFormacao) {
        if ($this->dal->verificarInscricao($email, $idFormacao)) {
            return "Já está inscrito nesta formação.";
        }
        return $this->dal->inscreverColaborador($email, $idFormacao);
    }

    public function verificarInscricao($email, $idFormacao) {
        return $this->dal->verificarInscricao($email, $idFormacao);
    }

    public function obterEstadoInscricao($email, $idFormacao) {
        return $this->dal->obterEstadoInscricao($email, $idFormacao);
    }

    public function atualizarEstadoFormacao($email, $idFormacao, $estado) {
        return $this->dal->atualizarEstadoFormacao($email, $idFormacao, $estado);
    }
    public function removerAssociacaoFormacao($email, $idFormacao) {
        return $this->dal->removerAssociacaoFormacao($email, $idFormacao);
    }
}
?>