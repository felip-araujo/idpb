<?php
// pagina_logada.php

require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_celula = $_POST['numero_celula'];

    // Armazenar o número da célula em uma variável de sessão
    session_start();
    $_SESSION['numero_celula'] = $numero_celula;

    // Aqui deve buscar os membros da célula correspondente no banco de dados
    $query = "SELECT nome_completo FROM membros WHERE numero_celula = :numero_celula";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':numero_celula', $numero_celula);
    $stmt->execute();
    $membros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Exibir os membros em um formulário para marcação de presença
    echo "<form action='processa_relatorio.php' method='post'>"; // Alteração aqui
    foreach ($membros as $membro) {
        echo "<label><input type='checkbox' name='presenca[]' value='{$membro['nome_completo']}'> {$membro['nome_completo']}</label><br>";
    }
    echo "<input type='hidden' name='numero_celula' value='{$numero_celula}'>";
    echo "<label>Data do relatório:</label><input type='date' name='data_relatorio' required><br>";
    echo "<label>Houve conversão?</label><input type='checkbox' name='conversao'><br>";
    echo "<label>Foi um evento?</label><input type='checkbox' name='evento'><br>";
    echo "<input type='submit' value='Enviar Relatório'>";
    echo "</form>";
} else {
    echo "Método inválido";
}
?>
