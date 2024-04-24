<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'conexao.php';
try {
    // Consultas para buscar os dados
    $celulas = $pdo->query("SELECT Numero_Celula FROM Celulas_X")->fetchAll(PDO::FETCH_ASSOC);
    $supervisoes = $pdo->query("SELECT Numero_Supervisao FROM Supervisao_X")->fetchAll(PDO::FETCH_ASSOC);
    $coordenacoes = $pdo->query("SELECT Numero_Coordenacao FROM Coordenacao_X")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na base de dados: " . $e->getMessage());
}


try {
    $funcoes = $pdo->query("SELECT ID_Funcao, Nome_Funcao FROM Funcoes_X ")->fetchAll(PDO::FETCH_ASSOC);
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
    $funcao_usuario = $_POST['funcao_usuario'];
}

$qremail = $pdo->prepare("SELECT Email FROM Usuarios_X where Email = :email");
$qremail->bindParam(':email', $email);
$qremail->execute();
$retorno = $qremail->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['enviar'])) {

    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $nome = $_POST['nome'];
    $num_celula = $_POST['num_celula'];
    $num_supervisao = $_POST['num_supervisao'];
    $num_coord = $_POST['num_coord'];
    $funcao_usuario = $_POST['funcao_usuario'];

    $qremail = $pdo->prepare("SELECT Email FROM Usuarios_X where Email = :email");
    $qremail->bindParam(':email', $email);
    $qremail->execute();
    $retorno = $qremail->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($retorno)) {
        $_SESSION['mensagem'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Este usuário já foi cadastrado!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    } else {
        $stmt = $pdo->prepare("INSERT INTO Usuarios_X (Email, Senha, Nome, Numero_Celula, Numero_Supervisao, Numero_Coordenacao) 
                                   VALUES (:email, :senha, :nome, :num_celula, :num_supervisao, :num_coord)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':num_celula', $num_celula, PDO::PARAM_INT);
        $stmt->bindParam(':num_supervisao', $num_supervisao, PDO::PARAM_INT);
        $stmt->bindParam(':num_coord', $num_coord, PDO::PARAM_INT);

        $stmt->execute();
        $ultimoID = $pdo->lastInsertId();

        $qr_id_func = $pdo->prepare("SELECT ID_Funcao FROM Funcoes_X WHERE Nome_Funcao = :funcao_usuario");
        $qr_id_func->bindParam(':funcao_usuario', $funcao_usuario);
        $qr_id_func->execute();
        $id_funcao_result = $qr_id_func->fetch(PDO::FETCH_ASSOC);
        $id_funcao = $id_funcao_result['ID_Funcao'];

        $inserir_funcao = $pdo->prepare("INSERT INTO Usuario_Funcoes_X (ID_Usuario, ID_Funcao) VALUES (:ultimoID, :id_funcao)");
        $inserir_funcao->bindParam(':ultimoID', $ultimoID, PDO::PARAM_INT);
        $inserir_funcao->bindParam(':id_funcao', $id_funcao, PDO::PARAM_INT);

        if ($inserir_funcao->execute()) {
            $_SESSION['mensagem'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Usuário cadastrado com sucesso!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } else {
            $_SESSION['mensagem'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Erro ao cadastrar a função do usuário no Banco de Dados, contate o Administrador.
                    <button type="button" the "btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    }
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
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    

    <title>Inserir Usuários</title>
</head>

<style>
    body{
        background-color: #818181;
    }
</style>

<body> 

    <div class="container"> 

        <div> <?php if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    // Limpe a mensagem depois de exibi-la para não aparecer novamente após o refresh
                    unset($_SESSION['mensagem']);
                    ob_end_flush();
                } ?> </div>

        <form action="" method="POST">
            <label for="email" class="form-label ">Email</label>
            <input type="email" class="form-control" name="email" id="email">

            <label for="" class="form-label ">Senha</label>
            <div class="input-group">
                <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha">
                <span class="input-group-text">
                    <i class="fa fa-eye" id="togglePassword"></i>
                </span>
            </div>


            <label for="" class="form-label ">Nome Completo:</label>
            <input type="text" class="form-control" name="nome" id="nome">

            <label for="num_celula" class="form-label ">Número Célula</label>
            <select name="num_celula" id="num_celula" class="form-control">
                <?php foreach ($celulas as $celula) {
                    echo "<option value='{$celula['Numero_Celula']}'>{$celula['Numero_Celula']}</option>";
                } ?>

            </select>

            <label for="" class="form-label ">Número Supervisão</label>
            <select name="num_supervisao" id="num_s" class="form-control">
                <?php foreach ($supervisoes as $supervisao) {
                    echo "<option value='{$supervisao['Numero_Supervisao']}'>{$supervisao['Numero_Supervisao']}</option>";
                } ?>
            </select>

            <label for="" class="form-label ">Número Coordenação</label>
            <select name="num_coord" id="num_coord" class="form-control">
                <?php foreach ($coordenacoes as $coordenacao) {
                    echo "<option value='{$coordenacao['Numero_Coordenacao']}'>{$coordenacao['Numero_Coordenacao']}</option>";
                }
                ?>
            </select>

            <label for="" class="form-label ">Função do Usuário</label>
            <select name="funcao_usuario" id="funcao_usuario" class="form-control">
                <?php foreach ($funcoes as $funcao) {
                    echo "<option value='{$funcao['Nome_Funcao']}'>{$funcao['Nome_Funcao']}</option>";
                }
                ?>
            </select>

            <br><input type="submit" name="enviar" class="btn btn-primary">
        </form>
    </div>

</body> 

<script>
document.getElementById('togglePassword').addEventListener('click', function (e) {
    // Alternar entre visualizar e ocultar a senha
    const password = document.getElementById('senha');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    
    // Alternar o ícone
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});
</script> 
<script src="./ajax.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://kit.fontawesome.com/d4755c66d3.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-- Inclusão do JavaScript do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>


</html>