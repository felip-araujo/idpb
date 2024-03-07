<?php
require_once 'verficacoes.php';

if (isset($_GET['remover_imagem']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    // Consultar o banco de dados para obter o caminho da imagem a ser removida
    $sql = "SELECT foto FROM users2 WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $caminho_imagem = $row['foto'];
        // Remover a imagem do diretório
        if (unlink($caminho_imagem)) {
            // Remover o link da imagem do banco de dados
            $sql = "UPDATE users2 SET foto = NULL WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                echo '<script>alert("Imagem removida!");</script>';
                echo '<script>window.location.href="../v2";</script>';
            } else {
                echo '<script>alert("Erro ao remover o link da imagem do banco de dados!");</script>';
            }
        } else {
            echo '<script>alert("Erro ao remover a imagem do diretório!");</script>';
        }
    } else {
        echo '<script>alert("ID de usuário inválido!");</script>';
    }
}
?>
