<?php

require 'conexao.php';


try {
    // Consultas para buscar os dados
    $usuarios = $pdo->query("SELECT Nome FROM Usuarios_X")->fetchAll(PDO::FETCH_ASSOC);
    $funcoes = $pdo->query("SELECT ID_Funcao, Nome_Funcao FROM Funcoes_X ")->fetchAll(PDO::FETCH_ASSOC);

    // $coordenacoes = $pdo->query("SELECT Numero_Coordenacao FROM Coordenacao_X")->fetchAll(PDO::FETCH_ASSOC); 
} catch (PDOException $e) {
    die("Erro na base de dados: " . $e->getMessage());
}



if (isset($_POST['enviar'])) {
    $usuario = $_POST['usuario'];
    $nova_funcao = $_POST['nova_funcao'];

    $busca_id  = $pdo->prepare("SELECT ID_Usuario FROM  Usuarios_X WHERE Nome = :nome");
    $busca_id->bindParam(':nome', $usuario, PDO::PARAM_STR);
    $busca_id->execute();
    $retorno_id = $busca_id->fetch(PDO::FETCH_ASSOC);
    $id_usuario = $retorno_id['ID_Usuario']; 

    $busca_id_funcao = $pdo->prepare("SELECT ID_Funcao FROM Funcoes_X WHERE Nome_Funcao = :nova_funcao");
    $busca_id_funcao->bindParam(':nova_funcao', $nova_funcao, PDO::PARAM_STR);
    $busca_id_funcao->execute();
    $retorno_id_funcao = $busca_id_funcao->fetch(PDO::FETCH_ASSOC);
    $id_funcao = $retorno_id_funcao['ID_Funcao'];

    $alterar = $pdo->prepare("UPDATE Usuario_Funcoes_X SET ID_Funcao = :id_funcao WHERE ID_Usuario = :id_usuario");
    $alterar->bindParam(':id_funcao', $id_funcao);
    $alterar->bindParam(':id_usuario', $id_usuario); 

    if ($alterar->execute()) {

        $_SESSION['mensagem'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Função atualizada com Sucesso!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {

        $_SESSION['mensagem'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Erro na solicitação, contate o administrador!
                    <button type="button" the "btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
} else {
}


?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Alterar Funcao</title>
</head>

<body>
    <div class="container" style="margin-top: .8rem;">
        <div> <?php if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    // Limpe a mensagem depois de exibi-la para não aparecer novamente após o refresh
                    unset($_SESSION['mensagem']);
                } ?> </div>

        <form action="" method="POST">
            <label for="usuario" class="form-label">Usuario:</label>
            <select name="usuario" id="usuario" class="form-control">
                <?php foreach ($usuarios as $usuario) {
                    echo "<option value='{$usuario['Nome']}'>{$usuario['Nome']}</option>";
                }

                ?>
            </select>
            <label for="nova_funcao" class="form-label">Nova Função:</label>
            <select name="nova_funcao" id="nova_funcao" class="form-control">
                <?php foreach ($funcoes as $funcao) {
                    echo "<option value='{$funcao['Nome_Funcao']}'>{$funcao['Nome_Funcao']}</option>";
                }
                ?>
            </select>
            <br><button class="btn btn-primary" name="enviar" id="enviar">Enviar</button>
        </form>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</html>