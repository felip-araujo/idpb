<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $email = $_POST['email'];
        $senha1 = $_POST['senha1']; 
        $senha2 = $_POST['senha2']; 

        if($senha1 == $senha2) {

            require 'conexao.php';     
            $query = "SELECT id FROM users2 WHERE email = '$email' "; 
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute([]);
            $id = $stmt->fetchAll(PDO::FETCH_ASSOC);
            print_r($id);

            
            
        } else {
            echo "As senhas não coincidem";
        }

    }



?>




