<?php
include './conexao.php';
try {
    $supervisoes = $pdo->query("SELECT Numero_Supervisao FROM Supervisao_X")->fetchAll(PDO::FETCH_ASSOC);

    $options = "";
    foreach ($supervisoes as $supervisao) {
        $options .= "<option value='" . $supervisao['Numero_Supervisao'] . "'>" . htmlspecialchars($supervisao['Numero_Supervisao']) . "</option>";
    }
    echo $options;
} catch (PDOException $e) {
    echo "<option> Erro ao carregar número de supervisão " . $e->getMessage() . "</option>";
}