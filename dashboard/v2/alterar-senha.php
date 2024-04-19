<?php 

session_start(); 
require_once '../conexao.php';

$mensagem = '';

if(isset($_POST['enviar'])) {
    $emailfornecido = $_POST['email'];
    $senha_antiga = $_POST['senha-antiga'];
    // $senha_nova = $_POST['senha-nova']; 

    $stmt = $pdo->prepare("SELECT * FROM usuarios where email = :email");
    $stmt->bindParam(':email', $emailfornecido);
    $stmt->execute(); 
    $result_stmt = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    
    $emaildb = $result_stmt[0]['email'];

    if (!$emailfornecido == $emaildb) {
        $mensagemErro = "Usuario não encontrado no banco de dados"; 
        echo $mensagemErro;
    } else {
        $mensagemSucess = "Usuario econtrado!"; 
        echo $mensagemSucess;
    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar senha</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Redefinir Senha</h2>
    <p>Preencha o formulário abaixo para redefinir sua senha</p>
</div>
    
<div class="container">
    
    <div class="alert alert-sucess"> <p><?php echo $mensagemSucess ?></p>  </div>
    <div class="alert alert-danger"><p><?php echo $mensagemErro ?></p></div>
        
    ?>


    <form action="" method="post">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" name="email" placeholder="seuemail@mail.com">
        <label for="email" class="form-label">Senha Antiga:</label>
        <input type="password" class="form-control" name="senha-antiga" placeholder="sua antiga senha">
        <label for="email" class="form-label">Nova Senha:</label>
        <input type="password" class="form-control" name="nova-senha" placeholder="sua nova senha"> 
        <br><button class="btn btn-success" name="enviar">Enviar</button>
    </form>
</div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d4755c66d3.js" crossorigin="anonymous"></script>
</html>