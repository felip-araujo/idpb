<?php
// pagina_logada.php

require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se o número da célula está presente na solicitação POST
    if(isset($_POST['Celula'])) {
        $Celula = $_POST['Celula'];
    } else {
        // Se não estiver presente, verificar se está presente na sessão
        session_start();
        if(isset($_SESSION['Celula'])) {
            $Celula = $_SESSION['Celula'];
        } else {
            // Se não estiver presente na sessão também, redirecionar para a página anterior ou exibir uma mensagem de erro
            // Aqui você pode decidir como lidar com essa situação
            // Por exemplo:
            header("Location: index.php");
            exit;
        }
    }

    // Aqui deve buscar os membros da célula correspondente no banco de dados
    $query = "SELECT nome_completo FROM membros WHERE Celula = :Celula";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':Celula', $Celula);
    $stmt->execute();
    $membros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Exibir os membros em um formulário para marcação de presença
    echo "<form action='processa_relatorio.php' method='post'>"; // Alteração aqui
    foreach ($membros as $membro) {
        echo "<label><input type='checkbox' name='presenca[]' value='{$membro['nome_completo']}'> {$membro['nome_completo']}</label><br>";
    }
    echo "<input type='hidden' name='Celula' value='{$Celula}'>";
    echo "<label>Data do relatório:</label><input type='date' name='data_relatorio' required><br>";
    echo "<label>Houve conversão?</label><input type='checkbox' name='conversao'><br>";
    echo "<label>Foi um evento?</label><input type='checkbox' name='evento'><br>";
    echo "<input type='submit' value='Enviar Relatório'>";
    echo "</form>";
} else {
    echo "Método inválido";
}
?>
