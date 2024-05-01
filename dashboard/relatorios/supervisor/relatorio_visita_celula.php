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

// Busca os números das células para o número de coordenação 3
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
    <script>
    // Função para garantir que apenas uma checkbox por categoria seja marcada
    function checkboxLimit(checkBox, group) {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="' + group + '"]');
        checkboxes.forEach((item) => {
            if (item !== checkBox) item.checked = false;
        });
    }
    </script>
</head>
<body>
    <h1>Relatório de Visita à Célula</h1>
    <form method="post">
        Número da Célula: <input type="number" name="numero_celula" required><br>
        Data da Visita: <input type="date" name="data_visita" required><br>

        <div>
            <strong>Recepção e Pontualidade:</strong><br>
            <label><input type="checkbox" name="recepcao_pontualidade" value="ruim" onclick="checkboxLimit(this, 'recepcao_pontualidade')">Ruim</label>
            <label><input type="checkbox" name="recepcao_pontualidade" value="regular" onclick="checkboxLimit(this, 'recepcao_pontualidade')">Regular</label>
            <label><input type="checkbox" name="recepcao_pontualidade" value="bom" onclick="checkboxLimit(this, 'recepcao_pontualidade')">Bom</label>
            <label><input type="checkbox" name="recepcao_pontualidade" value="otimo" onclick="checkboxLimit(this, 'recepcao_pontualidade')">Ótimo</label>
        </div>

        <!-- Repita a estrutura acima para cada categoria de avaliação -->
        <div>
            <strong>Quebra-gelo:</strong><br>
            <label><input type="checkbox" name="quebra_gelo" value="ruim" onclick="checkboxLimit(this, 'quebra_gelo')">Ruim</label>
            <label><input type="checkbox" name="quebra_gelo" value="regular" onclick="checkboxLimit(this, 'quebra_gelo')">Regular</label>
            <label><input type="checkbox" name="quebra_gelo" value="bom" onclick="checkboxLimit(this, 'quebra_gelo')">Bom</label>
            <label><input type="checkbox" name="quebra_gelo" value="otimo" onclick="checkboxLimit(this, 'quebra_gelo')">Ótimo</label>        </div>

        <div>
            <strong>Louvor:</strong><br>
            <label><input type="checkbox" name="louvor" value="ruim" onclick="checkboxLimit(this, 'louvor')">Ruim</label>
            <label><input type="checkbox" name="louvor" value="regular" onclick="checkboxLimit(this, 'louvor')">Regular</label>
            <label><input type="checkbox" name="louvor" value="bom" onclick="checkboxLimit(this, 'louvor')">Bom</label>
            <label><input type="checkbox" name="louvor" value="otimo" onclick="checkboxLimit(this, 'louvor')">Ótimo</label>        </div>

        <div>
            <strong>Edificação:</strong><br>
            <label><input type="checkbox" name="edificacao" value="ruim" onclick="checkboxLimit(this, 'edificacao')">Ruim</label>
            <label><input type="checkbox" name="edificacao" value="regular" onclick="checkboxLimit(this, 'edificacao')">Regular</label>
            <label><input type="checkbox" name="edificacao" value="bom" onclick="checkboxLimit(this, 'edificacao')">Bom</label>
            <label><input type="checkbox" name="edificacao" value="otimo" onclick="checkboxLimit(this, 'edificacao')">Ótimo</label>        </div>

        <div>
            <strong>Compartilhando:</strong><br>
            <label><input type="checkbox" name="compartilhando" value="ruim" onclick="checkboxLimit(this, 'compartilhando')">Ruim</label>
            <label><input type="checkbox" name="compartilhando" value="regular" onclick="checkboxLimit(this, 'compartilhando')">Regular</label>
            <label><input type="checkbox" name="compartilhando" value="bom" onclick="checkboxLimit(this, 'compartilhando')">Bom</label>
            <label><input type="checkbox" name="compartilhando" value="otimo" onclick="checkboxLimit(this, 'compartilhando')">Ótimo</label>        </div>

        <div>
            <strong>Cadeira da Bênção:</strong><br>
            <label><input type="checkbox" name="cadeira_da_bencao" value="ruim" onclick="checkboxLimit(this, 'cadeira_da_bencao')">Ruim</label>
            <label><input type="checkbox" name="cadeira_da_bencao" value="regular" onclick="checkboxLimit(this, 'cadeira_da_bencao')">Regular</label>
            <label><input type="checkbox" name="cadeira_da_bencao" value="bom" onclick="checkboxLimit(this, 'cadeira_da_bencao')">Bom</label>
            <label><input type="checkbox" name="cadeira_da_bencao" value="otimo" onclick="checkboxLimit(this, 'cadeira_da_bencao')">Ótimo</label>        </div>

        Observações: <textarea name="observacoes"></textarea><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
