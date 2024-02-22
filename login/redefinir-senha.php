<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $email = $_POST['email'];
        $senha1 = $_POST['senha1']; 
        $senha2 = $_POST['senha2']; 

        if($senha1 == $senha2) {

            require 'conexao.php';      
            $id_user = "SELECT id FROM users2 WHERE email = `$email`"; 
            // imprimindo a consulta de forma temporaria 
            $stmt = $pdo->prepare($id_user);

            // Vincular parâmetros
            $stmt->bindParam(':email', $email);

            // Executar a consulta
            $stmt->execute();

            // Verificar se a consulta retornou algum resultado
            if ($stmt->rowCount() > 0) {
                // Recuperar o resultado como uma matriz associativa
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "ID do usuário: " . $row["id"];
            } else {
                echo "Nenhum resultado encontrado.";
            }
            
        } else {
            echo "As senhas não coincidem";
        }

    }



?>




