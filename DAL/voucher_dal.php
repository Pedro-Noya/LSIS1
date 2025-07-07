<?php
class DAL_Voucher{
    private $conn;
    function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
        if ($this->conn->connect_error) {
            die("Erro na ligação à base de dados: " . $this->conn->connect_error);
        }
    }

    function getAllVouchers(){
        $sql=$this->conn->prepare("SELECT * FROM VoucherNos");
        $sql->execute();
        $resultado=$sql->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>