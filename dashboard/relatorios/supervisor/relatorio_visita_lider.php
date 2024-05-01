<?php
include 'idpb/dashboard/relatorios/conexao.php';

// Checa se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepara a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO Relatorio_Supervisao_2 (Numero_Celula, Nome_Lider, Data_Visita, Necessidades_Detectadas, Motivos_Oracao, Outras_Observacoes) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $_POST['numero_celula'], $_POST['nome_lider'], $_POST['data_visita'], $_POST['necessidades_detectadas'], $_POST['motivos_oracao'], $_POST['outras_observacoes']);

    // Executa a query
    if ($stmt->execute()) {
        echo "Relatório adicionado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Visita ao Líder</title>
</head>
<body>
    <h1>Relatório de Visita ao Líder</h1>
    <form method="post">
        Número da Célula: <input type="number" name="numero_celula" required><br>
        Nome do Líder: <input type="text" name="nome_lider" required><br>
        Data da Visita: <input type="date" name="data_visita" required><br>
        Necessidades Detectadas: <textarea name="necessidades_detectadas" required></textarea><br>
        Motivos de Oração: <textarea name="motivos_oracao" required></textarea><br>
        Outras Observações: <textarea name="outras_observacoes"></textarea><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
