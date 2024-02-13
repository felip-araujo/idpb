<?php 

session_start();

// $conexao = require_once "conexao.php"; 

$conexao = new mysqli("108.167.151.34", "evolud85_chris", "vGT{R_A^-E+4", "evolud85_idpb");

// Verifica se a conexão foi estabelecida com sucesso
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}


$email = $_POST['email'];
$senha = $_POST['senha']; 

$query = "SELECT id, nome FROM users2 WHERE email='$email' AND senha='$senha'";
$resultado = $conexao->query($query); 

if($resultado->num_rows == 1){

    $usuario = $resultado->fetch_assoc();
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome']; 
    header("Location: ../numero_celula.html");

} else {
    header("Location: login.php?erro_de_login=1");
}






?>


