<?php
include './conexao.php';
try {
    // Consultas para buscar os dados

    $celulas = $pdo->query("SELECT Numero_Celula FROM Celulas_X")->fetchAll(PDO::FETCH_ASSOC);

    $options = "";
    foreach ($celulas as $celula) {
        $options .= "<option value='" . $celula['Numero_Celula'] . "'>" . htmlspecialchars($celula['Numero_Celula']) . "</option>";
    }
    echo $options;
} catch (PDOException $e) {
    echo "<option> Erro ao carregar células " . $e->getMessage() . "</option>";
}

