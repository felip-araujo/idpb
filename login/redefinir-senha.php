<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $email = $_POST['email'];
        $senha1 = $_POST['senha1']; 
        $senha2 = $_POST['senha2']; 

        if($senha1 == $senha2) {

            require 'conexao.php';     
            // $query = "UPDATE id FROM users2 WHERE email = '$email' "; 

            $query = " UPDATE users2 SET senha = '$senha2' WHERE id = 1";
            
            
        } else {
            echo "As senhas não coincidem";
        }

    }



?>




