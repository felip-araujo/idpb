<?php
include 'conexao.php';
$id = $_POST['id'] ?? null;

$aprovar_exclusao = $pdo->prepare("UPDATE `Solicitacoes_Exclusao_X` SET `aprovado` = 1 WHERE `id` = :id_solicitacao");
$aprovar_exclusao->bindParam(':id_solicitacao', $id);
if ($aprovar_exclusao->execute()) {

    $buscar_id_usuario = $pdo->prepare("SELECT * FROM `Solicitacoes_Exclusao_X` WHERE `id` = :id_solicitacao");
    $buscar_id_usuario->bindParam(':id_solicitacao', $id);
    $buscar_id_usuario->execute();
    $id_usuario = $buscar_id_usuario->fetchAll(PDO::FETCH_ASSOC);

    foreach ($id_usuario as $key => $id) {
        $id_excluir = htmlspecialchars($id['id_usuario_exclusao']);
    }

    $deletar_funcoes = $pdo->prepare("DELETE FROM Usuario_Funcoes_X WHERE ID_Usuario = :i");
    $deletar_funcoes->bindParam(':i', $id_excluir);
    if ($deletar_funcoes->execute()) {

        $deletar = $pdo->prepare("DELETE FROM Usuarios_X WHERE ID_Usuario = :id_delete");
        $deletar->bindParam(':id_delete', $id_excluir);
        if ($deletar->execute()) {
            echo " Usuario removido do Sistema!";
        } else {
            echo "Erro na exclusão do usuario";
        }
    } else {
        echo "Erro ao deletar funcoes do usuario";
    }
} else {
    echo "Erro ao aprovar a exclusao";
}
