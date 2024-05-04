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
                <label for="lider_info" class="form-label">Selecione o Líder:</label>
                <select name="lider_info" id="lider_info" class="form-select" required>
                    <?php foreach ($lideres as $lider) { ?>
                        <option value="<?php echo $lider['Numero_Celula'] . '|' . $lider['Nome_Lider']; ?>">
                            <?php echo $lider['Nome_Lider']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="data_visita" class="form-label">Data da Visita:</label>
                <input type="date" name="data_visita" id="data_visita" class="form-control" required>
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
