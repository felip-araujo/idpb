<?php
session_start();
include './conexao.php';
$id_usuario = $_POST['deleteUserId'] ?? null;

try {

    $busca_funcao_adm = $pdo->prepare("SELECT * FROM Usuario_Funcoes_X WHERE ID_Usuario = :id_solicitante AND ID_Funcao = 6");
    $busca_funcao_adm->bindParam('id_solicitante', $_SESSION['id']);
    $busca_funcao_adm->execute();
    if ($busca_funcao_adm->rowCount() >= 1) {
        try {
            $deletar = $pdo->prepare("DELETE FROM Usuarios_X WHERE ID_Usuario = :id_usuario");
            $deletar->bindParam(':id_usuario', $id_usuario);
            if ($deletar->execute()) {
                echo "Usuário removido com sucesso!";
            } else {
                "Usuário nao removido!";
            }
        } catch (PDOException $e) {
        }
    } else {

        $inserir_solicitacao = $pdo->prepare(" 
        INSERT INTO Solicitacoes_Exclusao_X (id_usuario_solicitante, id_usuario_exclusao, mensagem, data)
        VALUES (:id_usuario_solicitante, :id_usuario_exclusao, :mensagem, NOW())");
        $inserir_solicitacao->bindParam(':id_usuario_solicitante', $_SESSION['id']);
        $inserir_solicitacao->bindParam(':id_usuario_exclusao', $id_usuario);
        $inserir_solicitacao->bindValue(':mensagem', "{$_SESSION['nome']} solicitou a exclusão.");

        if ($inserir_solicitacao->execute()) {
            echo "Solicitação enviada ao administrador!";
        } else {
            echo "Erro na Solicitação!";
        }
    }
} catch (PDOException $e) { 
}


