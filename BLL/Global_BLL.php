<?php
require_once __DIR__ . '/../DAL/Global_DAL.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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

    $mail->addAttachment(__DIR__ . '/../Imagens/mailLogo.png', 'Imagem-Logo.png');

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

    return true;
  } catch (Exception $e) {
    error_log("Erro ao enviar o email: {$mail->ErrorInfo}");
    return false;
  }
}

function enviarEmailAlerta($email, $titulo, $descricao) {
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
        $mail->addAddress($email, 'Colaborador(a)');

        $mail->addAttachment(__DIR__ . '/../Imagens/mailLogo.png', 'Imagem-Logo.png');

        $mail->isHTML(true);
        $mail->Subject = "Alerta: {$titulo}";
        $mail->Body = "<h1>Alerta: {$titulo}</h1>
                   <p>{$descricao}</p>
                   <p>Obrigado por se juntar a nós!</p>";

        $mail->send();

        return true;
  } catch (Exception $e) {
    error_log("Erro ao enviar o email: {$mail->ErrorInfo}");
    return false;
  }
}

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

    public function criarDocumento($tipoDocumento, $conteudo, $estado) {
        // Método para criar um documento
        return $this->dal->criarDocumento($tipoDocumento, $conteudo, $estado);
    }
}
?>