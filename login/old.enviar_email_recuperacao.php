<?php

// esqueci_senha.php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar e-mail do usuário (você pode adicionar mais validações aqui)
    $email = $_POST['email'];  
    
    // Lógica para verificar se o e-mail existe no banco de dados






    // Se o e-mail existir, gerar um token aleatório e armazená-lo na sessão
    $token = bin2hex(random_bytes(16)); // Gera um token aleatório de 16 bytes
    
    // Armazena o token na sessão
    $_SESSION['reset_token'] = $token;
    $_SESSION['reset_email'] = $email; 

    
    
    // Enviar e-mail com o link contendo o token para o usuário
    // ...
    
    // Redirecionar para a página de sucesso ou exibir uma mensagem de sucesso
    // header("Location: sucesso.php");
    // exit();
}


// LOG DE ERROS ( RETIRAR DEPOIS DE PRONTO )
error_reporting(E_ALL);
ini_set('display_errors', 1); 
// LOG DE ERROS ( RETIRAR DEPOIS DE PRONTO )


require 'C:\wamp64\www\idpb\PHPMailer\src\PHPMailer.php';
require 'C:\wamp64\www\idpb\PHPMailer\src\SMTP.php';
require 'C:\wamp64\www\idpb\PHPMailer\src\Exception.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber o email fornecido pelo usuário 
    $email = $_POST['email'];
    $nome_usuario = 'nome'; 

}

$codigo_acesso = rand(100000, 999999);

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
