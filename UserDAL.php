<?php
class DAL{
    private $conn;
    function __construct(){
        $this->conn=new PDO('mysql:host=localhost;dbname=tlantic_db','root','');
    }
    function createUtilizador($username, $email, $password_hash, $role='collaborator'){
        if($this->conn){
            $statement=$this->conn->prepare("INSERT INTO utilizador(username, email, password_hash, role) VALUES (?, ?, ?, ?)");
            $statement->bindParam(1, $username);
            $statement->bindParam(2, $email);
            $statement->bindParam(3, $password_hash);
            $statement->bindParam(4, $role);
        return ($statement->execute());
    }
    return false;
    }
}

?>