<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require '../php/conexao.php';

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];
    $dataAtual = date('Y-m-d H:i:s');

    $busca = $pdo->prepare("SELECT * FROM Troca_Senha_Usuarios WHERE codigo = :codigo");
    $busca->bindParam(':codigo', $codigo_enviado);
    $busca->execute();
    $resultado = $busca->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $codigo_db = $resultado['codigo'];
        $data_expiracao = $resultado['data_expiracao'];

        if ($data_expiracao > $dataAtual) {
            echo "<script type='text/javascript'>
                    alert('Código Expirado!');
                    
                </script>";
            exit;
        }
    } else {
    }
} else {
    echo "Código não fornecido.";
}
?>


<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Altere sua senha</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asstes.login/login.css">
    <link rel="icon" href="../assets/images/f_logo.svg">


</head>

<body>
    <div class="container-wrapper">
        <div class="container-login">

            <form class="formulario" action="" method="post">
                <div class="input-box">
                    <label for="nova-senha">
                        <i class="fa-solid fa-lock"></i>
                    </label>
                    <input class="input" type="password" id="nova-senha" name="nova-senha" placeholder="crie uma  nova senha" required>
                    <span class="icon password-icon">
                        <i class="senha-icon2 fa-regular fa-eye-slash" onclick="togglePasswordVisibility2()"></i>
                    </span>
                </div>
                <div class="input-box">
                    <label for="senha">
                        <i class="fa-solid fa-lock"></i>
                    </label>
                    <span class="icon password-icon">
                        <i class="senha-icon fa-regular fa-eye-slash" onclick="togglePasswordVisibility()"></i>
                    </span>
                    <input class="input" type="password" id="senha" name="senha" placeholder="confirme a sua nova senha" required oninput="checkPasswordStrength()">
                </div>
                <button class="input-btn" type="submit" name="entrar">Entrar</button>
            </form>


        </div>
    </div>
    <!-- codigo de importação do font awesome -->
    <script src="https://kit.fontawesome.com/d4755c66d3.js" crossorigin="anonymous"></script>
    <script src="../asstes.login/main.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</body>

</html>