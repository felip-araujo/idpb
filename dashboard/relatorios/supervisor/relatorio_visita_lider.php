<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Visita ao Líder</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#numero_celula').change(function() {
            var numeroCelula = $(this).val();
            if (numeroCelula) {
                $.ajax({
                    url: 'getLider.php',
                    type: 'POST',
                    data: {numero_celula: numeroCelula},
                    success: function(response) {
                        $('#nome_lider').val(response);
                    }
                });
            } else {
                $('#nome_lider').val(''); // Limpar o campo se nenhuma célula for selecionada
            }
        });
    });
    </script>
</head>
<body>
    <h1>Relatório de Visita ao Líder</h1>
    <form method="post">
        Número da Célula: <select name="numero_celula" id="numero_celula" required>
            <?php foreach ($celulas as $celula) { ?>
                <option value="<?php echo $celula['Numero_Celula']; ?>">
                    <?php echo $celula['Numero_Celula']; ?>
                </option>
            <?php } ?>
        </select><br>
        Nome do Líder: <input type="text" name="nome_lider" id="nome_lider" required readonly><br>
        Data da Visita: <input type="date" name="data_visita" required><br>
        Necessidades Detectadas: <textarea name="necessidades_detectadas" required></textarea><br>
        Motivos de Oração: <textarea name="motivos_oracao" required></textarea><br>
        Outras Observações: <textarea name="outras_observacoes"></textarea><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
