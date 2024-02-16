<?php

session_start();

// Incluir o arquivo de conexão PDO
require 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

// Query para verificar se o usuário existe
$query = "SELECT email FROM users2 WHERE email=:email AND senha=:senha";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $senha);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $_SESSION['usuario_email'] = $email;
    header("Location: /idpb/dashboard/index.php");
} else {
    header("Location: login.php?erro_de_login=1");
}

?>
