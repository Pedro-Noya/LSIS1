<?php
session_start();
//include "../DAL/login_dal.php";
include "login_dal.php";


/*function fazerLogin(){
  $erro = '';

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dal = new DAL_login();
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $numMec = $dal->entrarUtilizador($email, $password);
    if ($idUtilizador !== false) {
      session_regenerate_id(true);
      $_SESSION['username'] = $username;
      $_SESSION['id_utilizador'] = $idUtilizador;  // guardar o ID aqui
      header("Location: index.php");
      exit;
    } else {
      $erro = "Credenciais incorretas.";
    }
  }
}*/


function isThisACallback(): bool{
  if (empty($_POST['email']) || empty($_POST['password'])) {
    return false;
  }
  return true;
}
function displayForm() {
  echo '<form action="login.php" method="POST">
      <input type="text" name="email" placeholder="Email de Utilizador" required><br>
      <input type="password" name="password" placeholder="Palavra-Passe" required><br>
      <button type="submit">Login</button>
    </form>';
}
function showUI(){
  if(!isThisACallback()){
    displayForm();
  }
  else{
    try{
      $dal = new DAL_login();
      $login = $dal->entrarUtilizador($_POST["email"],$_POST["password"]);
      if($login){
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["password"] = $_POST["password"];
        header("Location: atualizar_perfil.php");
      }
      else{
        displayForm();
        echo "Email ou password incorretos!";
      }
    }
    catch(RuntimeException $e){
      echo "<div>".$e->getMessage()."</div>";
    }
  }
}
