<?php 
session_start();

require 'conexao.php';
require 'C:\wamp64\www\idpb\PHPMailer\src\PHPMailer.php';
require 'C:\wamp64\www\idpb\PHPMailer\src\SMTP.php';
require 'C:\wamp64\www\idpb\PHPMailer\src\Exception.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;  

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; 
    
    // Query para verificar se o email existe
    $query = "SELECT email, nome FROM users2 WHERE email=:email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC); 

    // Se o Email Existe Envia código de autenticação
    if ($resultado) {
        
        $codigo_acesso = rand(100000, 999999); 

        // Armazena o token na sessão
        $_SESSION['reset_codigo_acesso'] = $codigo_acesso;
        $_SESSION['reset_email'] = $email;

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.titan.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'suporte@sistemaidpb.evoludesign.com.br';
        $mail->Password = '-}*=_X46$ruM-6g';
        $mail->Port = 587; // Porta SMTP padrão

        // Configurações adicionais, se necessário 

        $mail->setFrom('suporte@sistemaidpb.evoludesign.com.br', 'Suporte IDPB');
        $mail->addAddress($email); // Endereço de e-mail do destinatário
        $mail->Subject = 'Recuperacao de Senha'; 
        $mail->Body = 'Seu código de acesso é: ' . $codigo_acesso;

    try {
        $mail->send();
    echo "<script>alert('E-mail Enviado')</script>"; 
    header("Location: validar-codigo.php");

    } catch (Exception $e) {
        echo "<script>alert('Erro no Envio do E-mail')</script>" . $mail->ErrorInfo;
        echo "<script> window.location.href = '../login';</script>";
    } 
    
    } else {
    
    echo "<script>alert('Email não Cadastrado')</script>";
    header("Location: index.html");
}

}

?>