<?php
require '../php/conexao.php';

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Verifica se o código é válido e não expirou
    $sql = "SELECT * FROM Troca_Senha_Usuarios WHERE codigo = :codigo AND usado = FALSE AND data_expiracao < NOW()";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        // O código é válido, mostre o formulário para redefinir a senha
        echo '<form action="processa-troca-senha.php" method="post">
                <input type="hidden" name="codigo" value="' . htmlspecialchars($codigo) . '">
                <label for="nova_senha">Nova Senha:</label>
                <input type="password" id="nova_senha" name="nova_senha" required>
                <button type="submit">Redefinir Senha</button>
              </form>';
    } else {
        echo "Código inválido ou expirado.";
    }
} else {
    echo "Código não fornecido.";
}
?>
