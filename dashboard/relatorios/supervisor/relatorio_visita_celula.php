<?php
include 'idpb/dashboard/relatorios/conexao.php';

// Busca os números das células para o número de coordenação 3
$query = "SELECT DISTINCT Numero_Celula FROM Usuarios_X WHERE Numero_coordenacao = 3";
$result = $conn->query($query);

$celulas = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $celulas[] = $row['Numero_Celula'];
    }
} else {
    echo "0 resultados encontrados.";
}

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
    <script>
    // Função para garantir que apenas uma checkbox por grupo seja marcada
    function checkboxLimit(checkboxElem, groupName) {
        let checkboxes = document.querySelectorAll('input[name="' + groupName + '"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
        checkboxElem.checked = true;
    }
    </script>
</head>
<body>
    <h1>Relatório de Visita à Célula</h1>
    <form method="post">
        Número da Célula: <select name="numero_celula" required>
            <?php foreach ($celulas as $celula) { ?>
                <option value="<?php echo $celula; ?>"><?php echo $celula; ?></option>
            <?php } ?>
        </select><br>
        Data da Visita: <input type="date" name="data_visita" required><br>
        <label>Recepção e Pontualidade:</label><br>
        <!-- Inserir aqui os checkboxes para os campos de avaliação conforme o exemplo anterior -->
        Observações: <textarea name="observacoes"></textarea><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
