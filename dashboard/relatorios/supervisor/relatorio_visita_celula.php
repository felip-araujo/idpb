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

// Busca os números das células para a coordenação 14 na tabela Usuarios_X
$query = "SELECT DISTINCT Numero_Celula FROM Usuarios_X WHERE Numero_Coordenacao = 14";
try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $celulas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao executar consulta: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Visita à Célula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Relatório de Visita à Célula</h1>
        <form method="post">
            <label class="form-label" for="numero_celula">Selecione a Célula:</label>
            <select name="numero_celula" id="numero_celula" class="form-select" required>
                <?php foreach ($celulas as $celula) { ?>
                    <option value="<?php echo $celula['Numero_Celula']; ?>">
                        <?php echo $celula['Numero_Celula']; ?>
                    </option>
                <?php } ?>
            </select>
            <br>
            Data da Visita: <input type="date" name="data_visita" class="form-control" required>
            <br>

            <!-- Implementação da lógica para checkboxes com estilos de botões -->
            <div class="mb-3">
                <strong>Recepção e Pontualidade:</strong><br>
                <div class="btn-group" role="group" aria-label="Recepção e Pontualidade">
                    <input type="checkbox" class="btn-check" id="ruim" name="recepcao_pontualidade" value="ruim" autocomplete="off" onclick="checkboxLimit(this, 'recepcao_pontualidade')">
                    <label class="btn btn-danger" for="ruim">Ruim</label>

                    <input type="checkbox" class="btn-check" id="regular" name="recepcao_pontualidade" value="regular" autocomplete="off" onclick="checkboxLimit(this, 'recepcao_pontualidade')">
                    <label class="btn btn-warning" for="regular">Regular</label>

                    <input type="checkbox" class="btn-check" id="bom" name="recepcao_pontualidade" value="bom" autocomplete="off" onclick="checkboxLimit(this, 'recepcao_pontualidade')">
                    <label class="btn btn-primary" for="bom">Bom</label>

                    <input type="checkbox" class="btn-check" id="otimo" name="recepcao_pontualidade" value="otimo" autocomplete="off" onclick="checkboxLimit(this, 'recepcao_pontualidade')">
                    <label class="btn btn-success" for="otimo">Ótimo</label>
                </div>
            </div>

            <!-- Outros campos podem ser adicionados conforme necessário, usando o mesmo padrão para checkboxes -->
            <br>
            Observações: <textarea name="observacoes" class="form-control"></textarea><br>
            <input type="submit" value="Enviar" class="btn btn-primary">
        </form>
    </div>

    <script>
        // Função para garantir que apenas uma checkbox por categoria seja marcada
        function checkboxLimit(checkBox, group) {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="' + group + '"]');
            checkboxes.forEach((item) => {
                if (item !== checkBox) item.checked = false;
            });
        }
    </script>
</body>
</html>
