<?php
// Incluindo o arquivo de conexão que está no diretório pai
include '../conexao.php';

// Habilitar a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Busca os números das células para o número de coordenação 3
$query = "SELECT DISTINCT Numero_Celula FROM Usuarios_X WHERE Numero_coordenacao = 3";
try {
    $stmt = $pdo->query($query);
    $celulas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao executar consulta: " . $e->getMessage();
    exit;
}

// Checa se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Prepara a inserção no banco de dados usando a conexão PDO
        $stmt = $pdo->prepare("INSERT INTO Relatorio_Supervisao (Numero_Celula, Data_Visita, Recepcao_Pontualidade, Quebra_Gelo, Louvor, Edificacao, Compartilhando, Cadeira_Bencao, Observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $_POST['numero_celula']);
        $stmt->bindParam(2, $_POST['data_visita']);
        $stmt->bindParam(3, $_POST['recepcao_pontualidade']);
        $stmt->bindParam(4, $_POST['quebra_gelo']);
        $stmt->bindParam(5, $_POST['louvor']);
        $stmt->bindParam(6, $_POST['edificacao']);
        $stmt->bindParam(7, $_POST['compartilhando']);
        $stmt->bindParam(8, $_POST['cadeira_bencao']);
        $stmt->bindParam(9, $_POST['observacoes']);
        $stmt->execute();
        echo "Relatório adicionado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir dados: " . $e->getMessage();
    }
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
        Número da Célula: <select name="numero_celula" required>
            <?php foreach ($celulas as $celula) { ?>
                <option value="<?php echo $celula['Numero_Celula']; ?>"><?php echo $celula['Numero_Celula']; ?></option>
            <?php } ?>
        </select><br>
        Data da Visita: <input type="date" name="data_visita" required><br>
        <!-- Campos de checkbox e o resto do formulário aqui -->
    </form>
</body>
</html>
