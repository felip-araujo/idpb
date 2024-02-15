<?php 

session_start();

// Incluir o arquivo de conexão PDO
require 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha']; 

try {
    $query = "SELECT id, nome, email, senha FROM users2 WHERE email=:email AND senha=:senha";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $_SESSION['usuario_id'] = $resultado['id'];
        $_SESSION['usuario_nome'] = $resultado['nome']; 
        // Também é possível armazenar o email na sessão, se necessário
        $_SESSION['usuario_email'] = $resultado['email']; 
        header("Location: ../numero_celula.html");
    } else {
        echo "Usuário ou senha incorretos. Por favor, tente novamente.";
    }
} catch (PDOException $e) {
    echo "Erro ao executar a consulta SQL: " . $e->getMessage();
}

?>
