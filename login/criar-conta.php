<?php
// Incluindo o arquivo de conexão
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o e-mail já está em uso
    $stmt = $pdo->prepare('SELECT id FROM users2 WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $existeUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existeUsuario) {
        echo "<script>alert('Este e-mail já está em uso!')</script>";
    } else {
        // Gerar hash seguro da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir novo usuário no banco de dados
        $stmt = $pdo->prepare('INSERT INTO users2 (nome, email, senha) VALUES (:nome, :email, :senha)');
        $stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $senhaHash]);

        echo "<script>alert('Conta criada com sucesso!.')</script>";
        echo "<script>window.location.href = '/idpb/login';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Criar Conta</title>
    <link rel="stylesheet" href="/idpb/login/asstes.login/login.css">
    <link rel="shortcut icon" href="/idpb/assets/images/main-logo.png" type="image/x-icon">
</head> 

<style>

    .input{
        margin-bottom: .5rem;
    }

</style>

<body>

    <div class="container-wrapper">
        <div class="container-login">
            <img class="logotipo" src="/idpb/assets/images/main-logo.png" alt="">
            <h2>Criar Conta</h2> 
            <h4>Preencha os campos abaixo:</h4>
            <form class="formulario" method="post" action="">
                <input type="name" id="nome" name="nome" class="input" required placeholder="Nome Completo:  ex.: João da Silva">
                <input type="email" id="email" name="email" class="input" placeholder="Email: ex.: joao@gmail.com" required>
                <input type="password" id="senha" name="senha" class="input" placeholder="Crie uma senha" required>
                <input class="button" type="submit" value="Criar Conta">
            </form>
        </div>
    </div>


</body>

</html>