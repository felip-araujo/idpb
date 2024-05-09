<?php
session_start();
include './dashboard/v2/php/conexao.php';

try {
    $busca_funcao_adm = $pdo->prepare("SELECT * FROM Usuario_Funcoes_X WHERE ID_Usuario = :id_solicitante AND ID_Funcao = 6");
    $busca_funcao_adm->bindParam('id_solicitante', $_SESSION['id']);
    $busca_funcao_adm->execute();

    if ($busca_funcao_adm->rowCount() >= 1) {
        try {
            $buscar_solicitacoes = $pdo->query("SELECT
                se.id,
                se.id_usuario_solicitante,
                se.id_usuario_exclusao,
                se.mensagem,
                se.data,
                se.aprovado,
                u1.Nome AS nome_solicitante,
                u2.Nome AS nome_excluido
            FROM
                Solicitacoes_Exclusao_X se
            JOIN Usuarios_X u1 ON se.id_usuario_solicitante = u1.ID_Usuario
            JOIN Usuarios_X u2 ON se.id_usuario_exclusao = u2.ID_Usuario
            WHERE
                se.aprovado = 0;");
            $solicitacoes = $buscar_solicitacoes->fetchAll(PDO::FETCH_ASSOC);

            if (count($solicitacoes) > 0) {
                // Retornar as solicitações como JSON
                $response = array(
                    'success' => true,
                    'message' => 'Você tem ' . count($solicitacoes) . ' solicitações de exclusão pendentes.',
                    'data' => $solicitacoes
                );
            } else {
                $response = array(
                    'success' => true,
                    'message' => 'Não há solicitações de exclusão pendentes.',
                    'data' => null
                );
            }
        } catch (PDOException $e) {
            $response = array(
                'success' => false,
                'message' => 'Erro ao buscar solicitações de exclusão.',
                'data' => null
            );
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Você não tem permissão para acessar esta página.',
            'data' => null
        );
    }
} catch (PDOException $e) {
    $response = array(
        'success' => false,
        'message' => 'Erro ao buscar permissão de administrador.',
        'data' => null
    );
}

// Retornar a resposta como JSON
header('Content-Type: application/json');
echo json_encode($response);
