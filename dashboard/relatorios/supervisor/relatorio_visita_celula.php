<?php
include 'idpb/dashboard/relatorios/conexao.php';

// Habilitar a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Busca os números das células para o número de coordenação 3
$query = "SELECT DISTINCT Numero_Celula FROM Usuarios_X WHERE Numero_coordenacao = 3";
$result = $conn->query($query);

$celulas = [];
if ($result) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $celulas[] = $row['Numero_Celula'];
        }
    } else {
        echo "0 resultados encontrados. Verifique se há células para a coordenação 3.";
    }
} else {
    echo "Erro na consulta: " . $conn->error;
}

// Restante do código para processamento do formulário...
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
        Número da Célula: <select name="numero_celula" required>
            <?php foreach ($celulas as $celula) { ?>
                <option value="<?php echo $celula; ?>"><?php echo $celula; ?></option>
            <?php } ?>
        </select><br>
        Data da Visita: <input type="date" name="data_visita" required><br>
        <!-- Campos de checkbox e o resto do formulário aqui -->
    </form>
</body>
</html>
