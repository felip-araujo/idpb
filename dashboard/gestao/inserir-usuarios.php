<?php

session_start();
require 'conexao.php';


try {
    // Consultas para buscar os dados
    $celulas = $pdo->query("SELECT Numero_Celula FROM Celulas_X")->fetchAll(PDO::FETCH_ASSOC);
    $supervisoes = $pdo->query("SELECT Numero_Supervisao FROM Supervisao_X")->fetchAll(PDO::FETCH_ASSOC);
    $coordenacoes = $pdo->query("SELECT Numero_Coordenacao FROM Coordenacao_X")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na base de dados: " . $e->getMessage());
}


if (isset($_POST['enviar'])) {

    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha
    $nome = $_POST['nome'];
    $num_celula = $_POST['num_celula'];
    $num_supervisao = $_POST['num_supervisao'];
    $num_coord = $_POST['num_coord'];


    // $qremail = $pdo->prepare("SELECT Email FROM Usuarios_X where Email = ':email'");
    // $qremail->bindParam(':email', $email); 
    // $qremail->execute(); 
    // $retorno



    $stmt = $pdo->prepare("INSERT INTO Usuarios_X (Email, Senha, Nome, Numero_Celula, Numero_Supervisao, Numero_Coordenacao) 
                               VALUES (:email, :senha, :nome, :num_celula, :num_supervisao, :num_coord)");

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':num_celula', $num_celula, PDO::PARAM_INT);
    $stmt->bindParam(':num_supervisao', $num_supervisao, PDO::PARAM_INT);
    $stmt->bindParam(':num_coord', $num_coord, PDO::PARAM_INT); 

    

    // Execução da inserção
    if (!$stmt->execute()) {
        $_SESSION['mensagem'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Erro ao cadastrar usuário: ' . $e->getMessage() . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    } else {
        $_SESSION['mensagem'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Usuário cadastrado com sucesso!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Inclusão do CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Inserir Usuários</title>
</head>

<body>
    <div class="container">
        <h2 class="form-label text-center" style="margin-top: 1rem;">Inserir Usuários</h2>

        <div> <?php if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    // Limpe a mensagem depois de exibi-la para não aparecer novamente após o refresh
                    unset($_SESSION['mensagem']);
                } ?> </div>

        <form action="" method="POST">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email">

            <label for="" class="form-label">Senha</label>
            <input type="password" class="form-control" name="senha" id="senha">

            <label for="" class="form-label">Nome Completo:</label>
            <input type="text" class="form-control" name="nome" id="nome">

            <label for="num_celula" class="form-label">Número Célula</label>
            <select name="num_celula" id="num_celula" class="form-control">
                <?php foreach ($celulas as $celula) {
                    echo "<option value='{$celula['Numero_Celula']}'>{$celula['Numero_Celula']}</option>";
                } ?>

            </select>

            <label for="" class="form-label">Número Supervisão</label>
            <select name="num_supervisao" id="num_s" class="form-control">
                <?php foreach ($supervisoes as $supervisao) {
                    echo "<option value='{$supervisao['Numero_Supervisao']}'>{$supervisao['Numero_Supervisao']}</option>";
                } ?>
            </select>

            <label for="" class="form-label">Número Coordenação</label>
            <select name="num_coord" id="num_coord" class="form-control">
                <?php foreach ($coordenacoes as $coordenacao) {
                    echo "<option value='{$coordenacao['Numero_Coordenacao']}'>{$coordenacao['Numero_Coordenacao']}</option>";
                }
                ?>
            </select>

            <br><input type="submit" name="enviar" class="btn btn-primary">
        </form>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-- Inclusão do JavaScript do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>


</html>