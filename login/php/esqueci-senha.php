<?php
session_start();

require 'C:\xampp\htdocs\idpb\vendor\autoload.php'; // Carrega o autoloader do Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
date_default_timezone_set('America/Sao_Paulo');


if (isset($_POST['enviar'])) {
    require '../php/conexao.php';
    $email = $_POST['email'];

    $busca = $pdo->prepare("SELECT ID_Usuario, Email FROM Usuarios_X WHERE Email = :email");
    $busca->bindParam(':email', $email);
    $busca->execute();
    $resultado_usuario = $busca->fetch(PDO::FETCH_ASSOC);


    if (!$resultado_usuario) {
        echo "<script type='text/javascript'>
                alert('E-mail não cadastrado!');
                window.location.href = '../index.html';
              </script>";
        exit;
    }

    $EmailEncontrado = $resultado_usuario['Email'];
    $ID_Usuario = $resultado_usuario['ID_Usuario'];



    function gerarCodigo()
    {
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    $codigo = gerarCodigo();

    function enviarEmail( $ID_Usuario, $email, $codigo)
    {
        $mail = new PHPMailer(true); // Instancia o PHPMailer
        try {
            // Configurações do servidor
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP do Gmail
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tresdevs3@gmail.com'; // Substitua pelo seu endereço de email do Gmail
            $mail->Password   = 'j z n r h c z u a j e z d a g k'; // Substitua pela sua senha de aplicativo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587; // Porta SMTP

            // Destinatários
            $mail->setFrom('tresdevs3@gmail.com', 'no-reply'); // Substitua pelo seu endereço de email
            $mail->addAddress($email); // Endereço de email do destinatário

            // Conteúdo do Email
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = "Código de Verificação";
            $mail->Body    = "Seu código de verificação é <b>{$codigo}</b>";
            $mail->AltBody = "Seu código de verificação é {$codigo}";

            if ($mail->send()) {

                require '../php/conexao.php';
                $expiracao = date('Y-m-d H:i:s', strtotime('+10 minutes')); // Código expira em 10 minutos
                $sql = "INSERT INTO Troca_Senha_Usuarios (ID_Usuario, codigo, data_expiracao) VALUES (:ID_Usuario, :codigo, :expiracao)
                        ON DUPLICATE KEY UPDATE codigo = VALUES(codigo), data_expiracao = VALUES(data_expiracao), usado = FALSE";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':ID_Usuario', $ID_Usuario);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':expiracao', $expiracao);
                $stmt->execute();

                echo "<script type='text/javascript'>
            window.location.href = '../esqueci-senha/inserir-codigo.html';
          </script>";
                exit;
            };
        } catch (Exception $e) {
            echo "A mensagem não pôde ser enviada. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // Chama a função para enviar o e-mail
    enviarEmail( $ID_Usuario, $EmailEncontrado, $codigo);
}
