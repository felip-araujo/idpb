<?php
include './conexao.php';
try {
    // Consultas para buscar os dados

    $membros = $pdo->query("SELECT * FROM membros")->fetchAll(PDO::FETCH_ASSOC);

    $table = '<table class="table table-dark rounded">';
    $table .= '<thead style="margin-bottom: .5rem;">';
    $table .=  '<tr>';
    $table .=    '<th scope="col">Nome:</th>';
    $table .=    '<th scope="col">Email:</th>';
    $table .=    '<th scope="col">Data de Nascimento:</th>';
    $table .=  '</tr>';
    $table .= '</thead>';
    $table .= '<tbody>';
    
    // Loop para criar as linhas da tabela para cada membro
    foreach ($membros as $membro) {
        $table .=  '<tr>';
        $table .=    "<td>" . htmlspecialchars($membro['nome_completo']) . "</td>";
        $table .=    "<td>" . htmlspecialchars($membro['email']) . "</td>";
        $table .=    "<td>" . htmlspecialchars($membro['data_nascimento']) . "</td>";
        $table .=  '</tr>';
    }
    
    // Fechar o corpo da tabela e a tabela depois do loop
    $table .= '</tbody>';
    $table .= '</table>'; 
    
    echo $table;
    
} catch (PDOException $e) {
    echo "<option> Erro ao carregar células " . $e->getMessage() . "</option>";
}
