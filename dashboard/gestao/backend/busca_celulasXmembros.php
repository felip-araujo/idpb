<?php
include './conexao.php';
try {
    // Consultas para buscar os dados

    $celulas = $pdo->query("SELECT * FROM Celulas_X ")->fetchAll(PDO::FETCH_ASSOC);

    $table = '<table class="table table-dark rounded">';
    $table .= '<thead style="margin-bottom: .5rem;">';
    $table .=  '<tr>';
    $table .=    '<th scope="col">Número da Célula:</th>';
    $table .=    '<th scope="col">Nome do Líder:</th>';
    $table .=    '<th scope="col">Descrição:</th>';
    $table .=  '</tr>';
    $table .= '</thead>';
    $table .= '<tbody>';
    
    foreach ($celulas as $celula) {
        $table .=  '<tr>';
        $table .=    "<td>" . htmlspecialchars($celula['Numero_Celula']) . "</td>";
        $table .=    "<td>" . htmlspecialchars($celula['Nome_Lider']) . "</td>";
        $table .=    "<td>" . htmlspecialchars($celula['Descricao']) . "</td>";
        $table .=  '</tr>';
    }
    $table .= '</tbody>';
    $table .= '</table>'; 
    echo $table;
    
    
} catch (PDOException $e) {
    echo "<option> Erro ao carregar células " . $e->getMessage() . "</option>";
}


