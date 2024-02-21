<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['reset_codigo_acesso']) || !isset($_SESSION['reset_email'])) {
    // Redireciona para a página de login se as variáveis de sessão não estiverem definidas
    header("Location: index.html");
    exit();
}

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo_digitado = $_POST['codigo'];
    $codigo_gerado = $_SESSION['reset_codigo_acesso'];
    $email = $_SESSION['reset_email'];

    // Verifica se o código digitado corresponde ao código gerado
    if ($codigo_digitado == $codigo_gerado) {
        // Redireciona para a página de redefinição de senha
        header("Location: redefinir-senha.php");
        exit();
    } else {
        // Exibe uma mensagem de erro se o código estiver incorreto
        $erro = "Código incorreto. Por favor, tente novamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="asstes.login/login.css"> 
    <link rel="stylesheet" href="assets/css/image/main-logo.png">
    <title>Validar Código de Acesso</title>
</head>
<body> 
<div class="container-wrapper"> 
    <div class="container-login">
        <h4 class="cad">Por favor, digite o código de acesso que enviamos para o seu e-mail:</h2>
        <?php if(isset($erro)) { ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php } ?>
        <form class="formulario" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label class="cad" for="codigo">Código de Acesso:</label><br>
            <input  class="input" type="text" id="codigo" name="codigo"><br><br>
            <input class="button" type="submit" value="Validar">
        </form>
    </div>
</div>
</body>
</html>
