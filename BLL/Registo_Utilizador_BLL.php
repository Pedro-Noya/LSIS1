<?php
require_once __DIR__ . '/../DAL/Registo_Utilizador_DAL.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

function enviarEmailRegisto($emailPessoal, $emailEmpresa, $nome, $password) {
  $mail = new PHPMailer(true);
  try {
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->isSMTP();
    $mail->Host = 'smtp.mailersend.net';
    $mail->SMTPAuth = true;
    $mail->Username = 'MS_NvGkht@test-pzkmgq7zzenl059v.mlsender.net';
    $mail->Password = 'mssp.BJLcJSq.3yxj6ljy91xldo2r.IR4nNKe';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('grupo5tlantic@test-pzkmgq7zzenl059v.mlsender.net', 'TLantic');
    $mail->addAddress($emailPessoal, $nome);

    $mail->addAttachment('Imagens/mailLogo.png', 'Imagem-Logo.png');

    $mail->isHTML(true);
    $mail->Subject = 'Foi criada a sua conta na TLantic';
    $mail->Body = "<h1>Bem-vindo à TLantic, {$nome}!</h1>
                   <p>A sua conta foi criada pela nossa equipa. para registar os seus dados,</p>
                   <p>por favor aceda a <a href='localhost/PortalColaborador/login.php?email={$emailEmpresa}'>este link!</a></p>
                   <p>Para fazer o Login inicial, os seus dados são os seguintes:</p>
                   <p><b>Email: {$emailEmpresa}</b></p>
                   <p><b>Password: {$password}</b></p>
                   <p>Obrigado por se juntar a nós!</p>";

    $mail->send();
    echo '<script>alert("Email enviado com sucesso!");</script>';

    return true;
  } catch (Exception $e) {
    echo "Erro ao enviar o email: {$mail->ErrorInfo}";
    return false;
  }
}

class Registo_Utilizador_BLL {
  private $dal;

  public function __construct() {
    $this->dal = new Registo_Utilizador_DAL();
  }

  public function registarUtilizador($emailPessoal, $nome, $email, $password) {

    // 2. Verificar se o utilizador já existe
    if ($this->dal->existeUtilizador($email)) {
      return "O utilizador já existe.";
    }

    // 3. Criar hash da password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 4. Inserir utilizador
    $sucesso = $this->dal->createUtilizador(
      $email,
      $nome,
      $password_hash,
      1
    );

    if (!$sucesso) {
      return "Erro ao registar o utilizador.";
    }

    enviarEmailRegisto($emailPessoal, $email, $nome, $password);

    return true;
  }
}
?>
