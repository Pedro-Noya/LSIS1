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

    function insertVoucher($voucher){
        $sql=$this->conn->prepare("INSERT INTO VoucherNos(voucherNos)
                                VALUES(?)");
        $sql->bind_param("s",$voucher);
        $sql->execute();
    }
}
?>