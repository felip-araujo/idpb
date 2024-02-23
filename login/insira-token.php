<?php
// Incluindo o arquivo de conexão
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'])) {
    $token = $_POST['token'];

    // Verificar se o token é válido e não expirou
    $stmt = $pdo->prepare('SELECT id FROM users2 WHERE token = :token AND token_expira_em > NOW()');
    $stmt->execute(['token' => $token]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Token válido, redirecionar o usuário para a página de redefinição de senha
        header('Location: redefinir-senha.php?token=' . $token);
        exit;
    } else {
        echo "<script>alert('Token inválido ou expirado. Por favor, verifique seu e-mail novamente.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Insira o Token</title>
    <link rel="stylesheet" href="/idpb/login/asstes.login/login.css">
    <link rel="shortcut icon" href="/idpb/assets/images/main-logo.png" type="image/x-icon">
</head>

<style>
    
    
    .button{
        margin-top: -1rem;
    } 
    
</style>

<body>
    <div class="container-wrapper">
        <div class="container-login">
            <h2>Insira o Token</h2>
            <h4>Digite abaixo o código de 6 dígitos enviado para seu e-mail</h4>
            <form method="post" action="">
                <input class="input" type="text" id="token" name="token" required><br><br>
                <input class="button" type="submit" value="Enviar">
            </form>
        </div>
    </div>
</body>

</html>