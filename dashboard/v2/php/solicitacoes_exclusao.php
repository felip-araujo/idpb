<?php
include './conexao.php';

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


    $table = '<table class="table table-dark rounded">';
    $table .= '<thead style="margin-bottom: .5rem;">';
    $table .=  '<tr>';
    $table .=    '<th scope="col">Solicitante:</th>';
    $table .=    '<th scope="col">Exclusão:</th>';
    $table .=    '<th scope="col">Data:</th>';
    $table .=    '<th scope="col">Ação:</th>';
    $table .=  '</tr>';
    $table .= '</thead>';
    $table .= '<tbody>';



    foreach ($solicitacoes as $key => $solicitacao) {
        $table .=  '<tr>';
        $table .=    "<td>" . htmlspecialchars($solicitacao['nome_solicitante']) . "</td>";
        $table .=    "<td>" . htmlspecialchars($solicitacao['nome_excluido']) . "</td>";
        $table .=    "<td>" . htmlspecialchars($solicitacao['data']) . "</td>";
        $table .=    '<td><button class="btn btn-danger" onclick="confirmarExclusao(' . $solicitacao['id'] . $solicitacao['id_usuario_exclusao'] . ')" >Confirmar Exclusão</button></td>';
        $table .=    '<td><button class="btn btn-secondary" onclick="rejeitarExclusao(' . $solicitacao['id'] . ')">Rejeitar Exclusão</button></td>';
        $table .=  '</tr>';
    }

    $table .= '</tbody>';
    $table .= '</table>';

    echo $table; 

} catch (PDOException $e) {
}
