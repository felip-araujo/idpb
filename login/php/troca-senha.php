<?php
// require '../php/conexao.php';

// if (isset($_GET['codigo'])) {
//     $codigo = $_GET['codigo'];

//     // Verifica se o código é válido e não expirou
//     $sql = "SELECT * FROM Troca_Senha_Usuarios WHERE codigo = :codigo AND usado = FALSE AND data_expiracao < NOW()";
//     $stmt = $pdo->prepare($sql);
//     $stmt->bindParam(':codigo', $codigo);
//     $stmt->execute();
//     $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($resultado) {
//         // O código é válido, mostre o formulário para redefinir a senha
//         echo '<form action="processa-troca-senha.php" method="post">
//                 <input type="hidden" name="codigo" value="' . htmlspecialchars($codigo) . '">
//                 <label for="nova_senha">Nova Senha:</label>
//                 <input type="password" id="nova_senha" name="nova_senha" required>
//                 <button type="submit">Redefinir Senha</button>
//               </form>';
//     } else {
//         echo "Código inválido ou expirado.";
//     }
// } else {
//     echo "Código não fornecido.";
// }
?>


<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Altere sua senha</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../asstes.login/login.css">
    <link rel="icon" href="../assets/images/f_logo.svg">

</head>

<body>
    <div class="container-wrapper">
        <div class="container-login">
            <img src="../assets/images/f_logo.svg" alt="" class="logotipo">
            <form class="formulario" action="../php/validar-codigo.php" method="post">
                <div class="input-box">
                    <input class="input" stype="email" id="senha" name="senha" placeholder="Digite a nova senha" required>
                </div>
                
                <div class="input-box">
                    <input class="input" stype="email" id="confirma-senha" name="confirma-senha" placeholder="Confirme a sua senha" required>
                </div>
                

                    <button class="input-btn" type="submit" name="enviar">Alterar senha</button>
                </div>
            </form>
        </div>
    </div>
    <!-- codigo de importação do font awesome -->
    <script src="https://kit.fontawesome.com/d4755c66d3.js" crossorigin="anonymous"></script>
    <script src="./asstes.login/main.js"></script>
</body>

</html>