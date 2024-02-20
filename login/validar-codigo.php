<?php
// validar_token.php

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o token foi enviado
    if (isset($_POST['token'])) {
        // Obtém o token enviado pelo formulário
        $token = $_POST['token'];

        // Lógica para verificar o token no banco de dados
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=seu_banco_de_dados', 'seu_usuario', 'sua_senha');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta preparada para verificar se o token existe no banco de dados
            $stmt = $pdo->prepare("SELECT * FROM tabela_de_tokens WHERE token = :token");
            $stmt->bindParam(':token', $token);
            $stmt->execute(); 
            
            // Verifica se o token foi encontrado
            if ($stmt->rowCount() > 0) {
                // Token válido, redireciona para a página de redefinição de senha
                header("Location: redefinir_senha.php?token=$token");
                exit(); 
            } else {
                // Token inválido, exibe mensagem de erro
                $error = "Token inválido. Por favor, verifique o token e tente novamente.";
            }
        } catch (PDOException $e) {
            // Tratar erros de conexão com o banco de dados
            $error = "Erro ao conectar ao banco de dados: " . $e->getMessage();
        }
    } else {
        // Se o token não foi enviado, exibe mensagem de erro
        $error = "Token não recebido. Por favor, forneça o token e tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Token</title>
</head>
<body>
    <h2>Validar Token</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="token">Token:</label>
        <input type="text" name="token" required>
        <button type="submit">Validar</button>
    </form>
</body>
</html>
