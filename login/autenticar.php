<?php

session_start();

// Incluir o arquivo de conexão PDO
require 'conexao.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['senha'])) {
    
    
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar usuário pelo e-mail
    $stmt = $pdo->prepare('SELECT nome, id, senha FROM users2 WHERE email = :email');
    $stmt->execute(['email' => $email]); 
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Verificar se a senha fornecida corresponde ao hash armazenado no banco de dados
        if (password_verify($senha, $usuario['senha'])) {
            // A senha está correta, logar o usuário
            // Aqui você pode redirecionar o usuário para a página de perfil, por exemplo  
            
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $email; 

            // echo "<script>window.location.href = '/idpb/dashboard';</script>";
            echo "<script>window.location.href = '/idpb/dashboard/v2';</script>";
        } 

        echo "<script>alert('Senha incorreta.')</script>";
        echo "<script>window.location.href = '/idpb/login';</script>";

        } else {
            // A senha está incorreta
            echo "<script>alert('Combinação de e-mail/senha inválida.')</script>";
            echo "<script>window.location.href = '/idpb/login';</script>";
        } 
    } else {
        // Usuário não encontrado
        echo "<script>alert('Nenhum usuário encontrado com o e-mail fornecido.')</script>";
    }

?>
