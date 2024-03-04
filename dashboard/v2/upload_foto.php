<?php
require_once 'verficacoes.php';

if (isset($_FILES['imagem'])) {
    $diretorio = 'C:\wamp64\www\idpb\upload/';
    $nome_arquivo = uniqid('perfil') . '_' . $_FILES['imagem']['name'];
    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio . $nome_arquivo)) {

        echo 'movido';
        $caminho_imagem = $diretorio . $nome_arquivo;
        $sql = "UPDATE users2 SET foto = :foto WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_string);
        $stmt->bindParam(':foto', $caminho_imagem);

        if ($stmt->execute()) {
            echo 'Link da imagem inserido no banco de dados';
        } else {
            echo 'erro ao inserir o link da imagem no banco de dados';
        }
    } else {
        echo ' erro ao mover o arquivo para o diretorio uploads';
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagem de Perfil</title>
</head>

<body>
    <h1>Upload de Imagem de Perfil</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="imagem">Selecione uma imagem:</label><br>
        <input type="file" id="imagem" name="imagem" accept="image/*"><br>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>