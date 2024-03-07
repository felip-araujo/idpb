<?php
require_once 'verficacoes.php';

if (isset($_FILES['imagem'])) {
    $diretorio = 'C:\wamp64\www\idpb\upload/';
    $nome_arquivo = uniqid('perfil') . '_' . $_FILES['imagem']['name'];
    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio . $nome_arquivo)) {


        $caminho_imagem = $diretorio . $nome_arquivo;
        $sql = "UPDATE users2 SET foto = :foto WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_string);
        $stmt->bindParam(':foto', $caminho_imagem);

        if ($stmt->execute()) {
            echo '<script>alert("Imagem enviada!");</script>';
            echo '<script>window.location.href="../v2";</script>';
            // echo 'Link da imagem inserido no banco de dados';
        } else {
            echo '<script>alert("Erro ao enviar!");</script>';
        }
    } else {
        echo '<script>alert("Erro ao mover a imagem!");</script>';
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/idpb/login/asstes.login/login.css">
    <link rel="shortcut icon" href="/idpb/assets/images/main-logo.png" type="image/x-icon">
    <title>Alterar foto de Perfil</title>
</head>

<body>
    <div class="container-wrapper">
        <div class="container-login">

            <h2 class="cad">Upload de Imagem de Perfil</h2>
            <form class="formulario" action="" method="post" enctype="multipart/form-data">
                <h4>Selecione uma imagem</h4>
                <input type="file" class="input" id="imagem" name="imagem" accept="image/*"><br>
                <input type="submit" class="button" value="Enviar">
            </form>

            <form action="remover-foto.php" method="GET">
                <input type="hidden" name="id" value="<?= $id_string; ?> "> <!-- Substitua "123" pelo ID do usuário -->
                <input type="hidden" name="remover_imagem" value="1">
                <input class="button" type="submit" value="Remover imagem atual">
            </form>

        </div>
    </div>
</body>

</html>