<?php

session_start();

// Incluir o arquivo de conexão PDO
require 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

// Query para verificar se o usuário existe
$query = "SELECT email, nome FROM users2 WHERE email=:email AND senha=:senha";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $senha);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    // Armazenar o email e o nome do usuário na sessão
    $_SESSION['usuario_email'] = $email;
    $_SESSION['usuario_nome'] = $resultado['nome']; // Obtendo o nome do usuário do resultado da consulta SQL

    header("Location: ../dashboard/index.php");
} else {
    
    echo "<script>alert('Credenciais Inválidas')</script>";
    echo "<script>window.location.href = '../login';</script>";
    
}

?>
