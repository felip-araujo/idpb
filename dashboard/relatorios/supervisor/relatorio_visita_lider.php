<?php
// Habilitar a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Caminho absoluto para o arquivo de conexão
require '/opt/bitnami/apache/htdocs/idpb/dashboard/relatorios/conexao.php';

// Verificar se a conexão foi estabelecida
if (!isset($pdo)) {
    die('Falha ao carregar a conexão com o banco de dados.');
}

// Busca os números das células para o número de supervisão 14
$query = "SELECT DISTINCT Numero_Celula FROM Usuarios_X WHERE Numero_Supervisao = 14";
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
        $stmt = $pdo->prepare("INSERT INTO Relatorio_Supervisao_2 (Numero_Celula, Nome_Lider, Data_Visita, Necessidades_Detectadas, Motivos_Oracao, Outras_Observacoes) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $_POST['numero_celula']);
        $stmt->bindParam(2, $_POST['nome_lider']);
        $stmt->bindParam(3, $_POST['data_visita']);
        $stmt->bindParam(4, $_POST['necessidades_detectadas']);
        $stmt->bindParam(5, $_POST['motivos_oracao']);
        $stmt->bindParam(6, $_POST['outras_observacoes']);
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
    <title>Relatório de Visita ao Líder</title>
</head>
<body>
    <h1>Relatório de Visita ao Líder</h1>
    <form method="post">
        Número da Célula: <select name="numero_celula" required>
            <?php foreach ($celulas as $celula) { ?>
                <option value="<?php echo $celula['Numero_Celula']; ?>">
                    <?php echo $celula['Numero_Celula']; ?>
                </option>
            <?php } ?>
        </select><br>
        Nome do Líder: <input type="text" name="nome_lider" required><br>
        Data da Visita: <input type="date" name="data_visita" required><br>
        Necessidades Detectadas: <textarea name="necessidades_detectadas" required></textarea><br>
        Motivos de Oração: <textarea name="motivos_oracao" required></textarea><br>
        Outras Observações: <textarea name="outras_observacoes"></textarea><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
