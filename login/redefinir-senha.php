<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha1 = $_POST['senha1'];
    $senha2 = $_POST['senha2'];

    if ($senha1 == $senha2) {
        require 'conexao.php';  
        try {
            // Consulta SQL para encontrar o ID do usuário
            $query = "SELECT id FROM users2 WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(); 

            if ($result) {
                $id = $result['id'];
                // Consulta SQL para atualizar a senha
                $query_update = "UPDATE users2 SET senha = :senha WHERE id = :id";
                $stmt_update = $pdo->prepare($query_update);
                $stmt_update->bindParam(':senha', $senha2);
                $stmt_update->bindParam(':id', $id);
                $stmt_update->execute();
                
                echo "Senha atualizada com sucesso!";
            } else {
                echo 'Usuário não encontrado';
            } 
        } catch(PDOException $e) {
            echo "Erro " . $e->getMessage();
        }
    } else {
        echo "As senhas não coincidem";
    }
}
?>
