<?php

session_start();
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
$query = "SELECT DISTINCT Numero_Celula FROM Usuarios_X WHERE Numero_Supervisao = :id";
try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $_SESSION['id']);
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
        <form method="post" action="processa_relatorio.php"> 
            <div class="mb-3">
                <label for="numero_celula" class="form-label">Selecione a Célula:</label>
                <select name="numero_celula" id="numero_celula" class="form-select" required>
                    <?php foreach ($celulas as $celula) { ?>
                        <option value="<?php echo $celula['Numero_Celula']; ?>">
                            <?php echo $celula['Numero_Celula']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="data_visita" class="form-label">Data da Visita:</label>
                <input type="date" name="data_visita" id="data_visita" class="form-control" required>
            </div>

            <!-- Avaliações com checkboxes -->
            <?php
                $categorias = [
                'Recepcao_Pontualidade' => 'Recepção e Pontualidade', 
                'Quebra_Gelo' => 'Quebra-gelo', 
                'Louvor' => 'Louvor', 
                'Edificacao' => 'Edificação', 
                'Compartilhando' => 'Compartilhando', 
                'Cadeira_Bencao' => 'Cadeira da Bênção'
            ];
            foreach ($categorias as $key => $label) {
                echo "<div class='mb-3'>
                        <strong>$label:</strong><br>";
                foreach (['ruim', 'regular', 'bom', 'otimo'] as $avaliacao) {
                    echo "<label class='btn btn-outline-primary'>
                            <input type='radio' name='$key' value='$avaliacao'> $avaliacao
                        </label>";
                }
                echo "</div>";
            }
            ?>


            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações:</label>
                <textarea name="observacoes" id="observacoes" class="form-control" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
</body>
</html>
