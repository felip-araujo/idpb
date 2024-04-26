<?php
include './conexao.php';
try {
    // Consultas para buscar os dados

    $coordenacoes = $pdo->query("SELECT Numero_Coordenacao FROM Coordenacao_X")->fetchAll(PDO::FETCH_ASSOC);

    $options = "";
    foreach ($coordenacoes as $coordenacao) {
        $options .= "<option value='" . $coordenacao['Numero_Coordenacao'] . "'>" . htmlspecialchars($coordenacao['Numero_Coordenacao']) . "</option>";
    }
    echo $options;
} catch (PDOException $e) {
    echo "<option> Erro ao carregar células " . $e->getMessage() . "</option>";
}
