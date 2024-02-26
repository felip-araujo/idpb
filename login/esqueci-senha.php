<?php
// Incluindo o arquivo de conexão
require 'conexao.php';

// REFERENCIAS PARA O PHPMAILER AWS PRODUÇÃO //
require '/home/bitnami/htdocs/idpb/PHPMailer/src/PHPMailer.php';
require '/home/bitnami/htdocs/idpb/PHPMailer/src/SMTP.php'; 
require '/home/bitnami/htdocs/idpb/PHPMailer/src/Exception.php';
// REFERENCIAS PARA O PHPMAILER AWS PRODUÇÃO //

// REFERENCIAS PARA O PHPMAILER LOCAL AMBIENTE DE TESTE //
require 'C:\wamp64\www\idpb\PHPMailer\src\PHPMailer.php';
require 'C:\wamp64\www\idpb\PHPMailer\src\SMTP.php';
require 'C:\wamp64\www\idpb\PHPMailer\src\Exception.php';
// REFERENCIAS PARA O PHPMAILER LOCAL AMBIENTE DE TESTE // 


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Função para gerar um token de segurança
function gerarToken()
{
    $token = mt_rand(100000, 999999);
    return $token;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Verificar se o e-mail existe no banco de dados
    $stmt = $pdo->prepare('SELECT id FROM users2 WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Gerar token de segurança único
        $token = gerarToken();
        $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Atualizar o token de segurança e a data de expiração no banco de dados
        $stmt = $pdo->prepare('UPDATE users2 SET token = :token, token_expira_em = :expiracao WHERE id = :id');
        $stmt->execute(['token' => $token, 'expiracao' => $expiracao, 'id' => $usuario['id']]);

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
        $mail->Body = 'Seu código de acesso é: ' . $token;

        try {
            $mail->send(); 
            header("Location: insira-token.php");
        } catch (Exception $e) {
            echo "<script>alert('Erro no Envio do E-mail')</script>" . $mail->ErrorInfo;
        }
    } else {

        echo "<script>alert('Email não cadastrado!')</script>";
        echo "<script>window.location.href = '/idpb/login';</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Esqueci a Senha</title>
    <link rel="stylesheet" href="/idpb/login/asstes.login/login.css">
    <link rel="shortcut icon" href="/idpb/assets/images/main-logo.png" type="image/x-icon">
</head> 

<style>
    h4 {
       margin-top: .8rem; 
       margin-bottom: -1.6rem;
    } 
    .button{
        margin-top: -0.2rem;
    }
</style>



<body>
    <div class="container-wrapper">
        <div class="container-login">
            <h2>Esqueci a Senha</h2>
            <h4>Insira o seu e-mail no campo abaixo para que possamos enviar o código de acesso.</h4>
            <form class="formulario" method="post" action="">
                <input class="input" type="email" id="email" name="email" placeholder="joao@gmail.com" required><br><br>
                <input class="button" type="submit" value="Enviar Código">
            </form>
        </div>
    </div>
</body>

</html>