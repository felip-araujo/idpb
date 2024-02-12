<?php 

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; 
    $confirmar_senha = $_POST['confirmar_senha'];

    if($senha !== $confirmar_senha){
        echo "Senhas não são iguais";
        exit();
    } 
}

?>