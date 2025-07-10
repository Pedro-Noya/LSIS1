<?php
class DAL_Dashboard {
    private $conn;

    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    function obterColaboradores() {
        $sql = "SELECT nome, dataNascimento, sexo, dataEntrada, funcao FROM Colaboradores";
        $result = $this->conn->query($sql);

        $colaboradores = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Calcular idade
                $idade = $this->calcularIdade($row['dataNascimento']);

                // Calcular tempo de empresa
                $tempo = $this->calcularAntiguidade($row['dataEntrada']);

                $colaboradores[] = [
                    'nome'   => $row['nome'],
                    'idade'  => $idade,
                    'genero' => strtolower($row['sexo']),
                    'tempo'  => $tempo,
                    'funcao' => $row['funcao']
                ];
            }
        }

        return $colaboradores;
    }

    private function calcularIdade($dataNascimento) {
        $nasc = new DateTime($dataNascimento);
        $hoje = new DateTime();
        $idade = $hoje->diff($nasc)->y;
        return $idade;
    }

    private function calcularAntiguidade($dataEntrada) {
        $entrada = new DateTime($dataEntrada);
        $hoje = new DateTime();
        $anos = $hoje->diff($entrada)->y;
        return $anos;
    }
}
?>