<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


require '/htdocs/idpb/PHPMailer/src/PHPMailer.php';
require '/htdocs/idpb/PHPMailer/src/SMTP.php';
require '/htdocs/idpb/PHPMailer/src/Exception.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber o email fornecido pelo usuário 
    $email = $_POST['email'];
    $nome_usuario = 'nome'; 

}

$codigo_acesso = 185;

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.titan.email';
$mail->SMTPAuth = true;
$mail->Username = 'suporte@sistemaidpb.evoludesign.com.br';
$mail->Password = '-}*=_X46$ruM-6g';
$mail->Port = 587; // Porta SMTP padrão

// Configurações adicionais, se necessário 

$mail->setFrom('suporte@sistemaidpb.evoludesign.com.br', 'Suporte IDPB');
$mail->addAddress($email, $nome_usuario); // Endereço de e-mail do destinatário
$mail->Subject = 'Recuperação de Senha';
$mail->Body = 'Seu código de acesso é: ' . $codigo_acesso;

try {
    $mail->send();
    echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
}



?> 