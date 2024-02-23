<?php
// Incluindo o arquivo de conexão
require 'conexao.php';

// Verificar se o token foi fornecido na URL
if (!isset($_GET['token'])) {
    echo "<script>alert('Token inválido!')</script>";
    exit;
}

$token = $_GET['token'];

// Verificar se o token é válido e ainda não expirou
$stmt = $pdo->prepare('SELECT id FROM users2 WHERE token = :token AND token_expira_em > NOW()');
$stmt->execute(['token' => $token]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "<script>alert('Token inválido ou expirado!')</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_senha']) && isset($_POST['confirmar_senha'])) {
    $novaSenha = $_POST['nova_senha'];
    $confirmarSenha = $_POST['confirmar_senha'];

    // Verificar se as senhas coincidem
    if ($novaSenha !== $confirmarSenha) {
        echo "<script>alert('As senhas fornecidas não coincidem.')</script>";
        Location('redefinir-senha.php?token=' . $token); 
        exit;

    }

    // Gerar hash seguro da nova senha
    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

    // Atualizar a senha do usuário no banco de dados
    $stmt = $pdo->prepare('UPDATE users2 SET senha = :senha, token = NULL, token_expira_em = NULL WHERE id = :id');
    $stmt->execute(['senha' => $senhaHash, 'id' => $usuario['id']]);

    echo "<script>alert('Sua senha foi redefinida com sucesso!')</script>";
    echo "<script>window.location.href = '/idpb/login';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title> 
    <link rel="stylesheet" href="/idpb/login/asstes.login/login.css">
    <link rel="shortcut icon" href="/idpb/assets/images/main-logo.png" type="image/x-icon">
</head>
<body> 

    <style>
        h2{
            margin-bottom: .3rem;
        }
        input{
            margin-bottom: .5rem;
        } 
        .button{
            margin-top: .2rem;
        }
    </style>
    

<div class="container-wrapper">
    <div class="container-login">
        <h2>Redefinir Senha</h2>
        <form method="post" action="">
            <input type="password" id="nova_senha" name="nova_senha" class="input" placeholder="nova senha" required>
            <input type="password" id="confirmar_senha" name="confirmar_senha" class="input" placeholder="confirmar nova senha" required>            
            <input type="submit" value="Redefinir Senha" class="button">
        </form>
    </div>
</div>
</body>
</html>
