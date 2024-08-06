<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
$dataHoraAtual = date('Y-m-d H:i:s');


require '../php/conexao.php';

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $busca = $pdo->prepare("SELECT * FROM Troca_Senha_Usuarios WHERE codigo = :codigo");
    $busca->bindParam(':codigo', $codigo);
    $busca->execute();
    $resultado = $busca->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $id_usuario = $resultado['ID_Usuario'];
        $data_expiracao = $resultado['data_expiracao'];
        $dataHoraAtual = date('Y-m-d H:i:s');

        if ($dataHoraAtual > $data_expiracao) {

            $mensagem = '<div class="alert alert-danger" role="alert">
            Código expirado, tente novamente mais tarde!
          </div>';
        } else {
            $mensagem = '<div class="alert alert-primary" role="alert" >
            Crie uma nova senha!
          </div>';

            if (isset($_POST['alterar-senha'])) {
                $novasenha = $_POST['nova-senha'];
                $confirmsenha = $_POST['confirm-senha'];

                // Verifica se as senhas coincidem
                if ($novasenha !== $confirmsenha) {
                    // echo 'Senhas não coincidem';
                    $mensagem = '<div class="alert alert-danger" role="alert">
                    Senhas não coincidem!
                  </div>';
                } else {
                    // Verifica o comprimento da senha
                    if (strlen($novasenha) < 8) {
                        // echo 'A senha deve ter pelo menos 8 caracteres';
                        $mensagem = '<div class="alert alert-danger" role="alert">
                        A senha deve ter pelo menos 8 caracteres
                  </div>';
                    }
                    // Verifica se há pelo menos uma letra maiúscula
                    elseif (!preg_match('/[A-Z]/', $novasenha)) {
                        // echo 'A senha deve ter pelo menos uma letra maiúscula';
                        $mensagem = '<div class="alert alert-danger" role="alert">
                        A senha deve ter pelo menos uma letra maiúscula
                  </div>';
                    }
                    // Verifica se há pelo menos uma letra minúscula
                    elseif (!preg_match('/[a-z]/', $novasenha)) {
                        // echo 'A senha deve ter pelo menos uma letra minúscula';
                        $mensagem = '<div class="alert alert-danger" role="alert">
                        A senha deve ter pelo menos uma letra minúscula
                  </div>';
                    }
                    // Verifica se há pelo menos um número
                    elseif (!preg_match('/\d/', $novasenha)) {
                        // echo 'A senha deve ter pelo menos um número';
                        $mensagem = '<div class="alert alert-danger" role="alert">
                        A senha deve ter pelo menos um número
                  </div>';
                    }
                    // Verifica se há pelo menos um caractere especial
                    elseif (!preg_match('/[\W]/', $novasenha)) {
                        // echo 'A senha deve ter pelo menos um caractere especial';
                        $mensagem = '<div class="alert alert-danger" role="alert">
                        A senha deve ter pelo menos um caractere especial
                  </div>';
                    } else {
                        // echo 'Senha válida';

                        $hashed_password = password_hash($nova_senha, PASSWORD_DEFAULT);
                        $trocaSenha = $pdo->prepare("UPDATE Usuarios_X SET Senha = :senha WHERE ID_Usuario = :id");
                        $trocaSenha->bindParam('senha', $hashed_password);
                        $trocaSenha->bindParam('id', $id_usuario, PDO::PARAM_INT);

                        if ($trocaSenha->execute()) {
                            $mensagem = '<div class="alert alert-success" role="alert">
                            Senha Alterada com sucesso!
                            </div>';
                        } else {
                            $mensagem = '<div class="alert alert-danger" role="alert">
                            Erro ao alterar senha!
                            </div>' . $stmt->errorInfo()[2];
                        }
                    }
                }
            }
        }
    } else {
    }
} else {
    $mensagem = '<div class="alert alert-danger" role="alert">
    Código não fornecido!
  </div>';
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

    <style>
        .valid {
            color: green;
            font-weight: 700;
            font-size: .8rem;
            background-color: white;
        }

        .invalid {
            color: red;
            font-weight: 700;
            font-size: .8rem;
            background-color: white;

        }
    </style>


</head>

<body>
    <div class="container-wrapper">
        <div class="container-login">

            <div id="mensagem" style="font-size: .8rem;">
                <strong>
                    <p> <?php echo $mensagem, $hashed_password ?> </p>
                </strong>
            </div>

            <form class="formulario" action="" method="post">
                <div class="input-box">
                    <label for="nova-senha">
                        <i class="fa-solid fa-lock"></i>
                    </label>
                    <input class="input" type="password" id="nova-senha" name="nova-senha" placeholder="crie uma  nova senha" required>
                    <span class="icon password-icon">
                        <i class="senha-icon2 fa-regular fa-eye-slash" onclick="togglePasswordVisibility('nova-senha','confirm-senha')"></i>
                    </span>
                </div>
                <div class="input-box">
                    <label for="senha">
                        <i class="fa-solid fa-lock"></i>
                    </label>
                    <input class="input" type="password" id="confirm-senha" name="confirm-senha" placeholder="confirme a sua nova senha" required oninput="checkPasswordStrength()">
                    <span class="icon password-icon">
                        <i class="senha-icon fa-regular fa-eye-slash" onclick="togglePasswordVisibilityConfirm('confirm-senha')"></i>
                    </span>
                </div>
                <button class="input-btn" type="submit" name="alterar-senha">Alterar Senha</button>

                <ul id="passwordCriteria" class="list-unstyled" style="margin-top: .4rem;">
                    <li id="length" class="invalid">Pelo menos 8 caracteres</li>
                    <li id="uppercase" class="invalid">Pelo menos uma letra maiúscula</li>
                    <li id="lowercase" class="invalid">Pelo menos uma letra minúscula</li>
                    <li id="number" class="invalid">Pelo menos um número</li>
                    <li id="special" class="invalid">Pelo menos um caractere especial</li>
                </ul>
            </form>


        </div>
    </div>
    <!-- codigo de importação do font awesome -->
    <script src="https://kit.fontawesome.com/d4755c66d3.js" crossorigin="anonymous"></script>
    <script src="../asstes.login/main.js"></script>
    <script src="./troca-senha.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</body>

</html>