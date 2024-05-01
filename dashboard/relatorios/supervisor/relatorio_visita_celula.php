<?php
include '..conexao.php';

// Checa se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepara a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO Relatorio_Supervisao (Numero_Celula, Data_Visita, Recepcao_Pontualidade, Quebra_Gelo, Louvor, Edificacao, Compartilhando, Cadeira_Bencao, Observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $_POST['numero_celula'], $_POST['data_visita'], $_POST['recepcao_pontualidade'], $_POST['quebra_gelo'], $_POST['louvor'], $_POST['edificacao'], $_POST['compartilhando'], $_POST['cadeira_bencao'], $_POST['observacoes']);

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
    <title>Relatório de Visita à Célula</title>
</head>
<body>
    <h1>Relatório de Visita à Célula</h1>
    <form method="post">
        Número da Célula: <input type="number" name="numero_celula" required><br>
        Data da Visita: <input type="date" name="data_visita" required><br>
        <label>Recepção e Pontualidade:</label>
        <select name="recepcao_pontualidade" required>
            <option value="ruim">Ruim</option>
            <option value="regular">Regular</option>
            <option value="bom">Bom</option>
            <option value="otimo">Ótimo</option>
        </select><br>
        Quebra Gelo: <select name="quebra_gelo" required>
            <option value="ruim">Ruim</option>
            <option value="regular">Regular</option>
            <option value="bom">Bom</option>
            <option value="otimo">Ótimo</option>
        </select><br>
        Louvor: <select name="louvor" required>
            <option value="ruim">Ruim</option>
            <option value="regular">Regular</option>
            <option value="bom">Bom</option>
            <option value="otimo">Ótimo</option>
        </select><br>
        Edificação: <select name="edificacao" required>
            <option value="ruim">Ruim</option>
            <option value="regular">Regular</option>
            <option value="bom">Bom</option>
            <option value="otimo">Ótimo</option>
        </select><br>
        Compartilhando: <select name="compartilhando" required>
            <option value="ruim">Ruim</option>
            <option value="regular">Regular</option>
            <option value="bom">Bom</option>
            <option value="otimo">Ótimo</option>
        </select><br>
        Cadeira da Benção: <select name="cadeira_bencao" required>
            <option value="ruim">Ruim</option>
            <option value="regular">Regular</option>
            <option value="bom">Bom</option>
            <option value="otimo">Ótimo</option>
        </select><br>
        Observações: <textarea name="observacoes"></textarea><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
