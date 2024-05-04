<?php
require '/opt/bitnami/apache/htdocs/idpb/dashboard/relatorios/conexao.php';

// Busca os líderes da supervisão na view criada
$query = "SELECT DISTINCT Numero_Celula, Nome_Lider FROM ViewCelulasInfo WHERE Numero_Coordenacao = 14";
try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $lideres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao executar consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Visita ao Líder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Relatório de Visita ao Líder</h1>
        <form method="post" action="processa_relatorio_2.php">
            <div class="mb-3">
                <label for="numero_celula" class="form-label">Selecione o Líder:</label>
                <select name="numero_celula" id="numero_celula" class="form-select" required>
                    <?php foreach ($lideres as $lider) { ?>
                        <option value="<?php echo $lider['Numero_Celula']; ?>">
                            <?php echo $lider['Nome_Lider']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="necessidades_detectadas" class="form-label">Necessidades Detectadas:</label>
                <textarea name="necessidades_detectadas" id="necessidades_detectadas" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="motivos_oracao" class="form-label">Motivos de Oração:</label>
                <textarea name="motivos_oracao" id="motivos_oracao" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="outras_observacoes" class="form-label">Outras Observações:</label>
                <textarea name="outras_observacoes" id="outras_observacoes" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
</body>
</html>
