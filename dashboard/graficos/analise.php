<?php
include_once 'conexao.php'; // Incluir o arquivo de conexão

// Contagem de membros por sexo
$sqlSexo = "SELECT genero, COUNT(*) AS total FROM membros WHERE numero_celula = '70' GROUP BY genero";
$stmtSexo = $pdo->prepare($sqlSexo);
$stmtSexo->execute();
$dadosSexo = $stmtSexo->fetchAll(PDO::FETCH_ASSOC);

$sexoLabels = ['Masculino', 'Feminino'];
$sexoData = ['Masculino' => 0, 'Feminino' => 0];
foreach ($dadosSexo as $linha) {
    if ($linha['genero'] === 'Masculino') {
        $sexoData['Masculino'] = (int)$linha['total'];
    } elseif ($linha['genero'] === 'Feminino') {
        $sexoData['Feminino'] = (int)$linha['total'];
    }
}

// Contagem de membros por participação em ministério
$sqlMinisterio = "SELECT participacao_ministerio, COUNT(*) AS total FROM membros WHERE numero_celula = '70' GROUP BY participacao_ministerio";
$stmtMinisterio = $pdo->prepare($sqlMinisterio);
$stmtMinisterio->execute();
$dadosMinisterio = $stmtMinisterio->fetchAll(PDO::FETCH_ASSOC);

// Consulta SQL para contar o número de membros na célula com o número '70'
$sqlTotalMembros = "SELECT COUNT(*) AS total FROM membros WHERE numero_celula = '70'";
$stmtTotalMembros = $pdo->query($sqlTotalMembros); // Corrigido de $sql para $sqlTotalMembros
$totalMembros = $stmtTotalMembros->fetchColumn(); // Corrigido de $stmt para $stmtTotalMembros


$ministerioLabels = [];
$ministerioData = [];
foreach ($dadosMinisterio as $linha) {
    $ministerioLabels[] = $linha['participacao_ministerio'];
    $ministerioData[] = $linha['total'];
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Análise de Membros da Célula 70</title>
    <link rel="stylesheet" href="estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body> 
    <div class="container w-50">
        <div class="graficos-container">
            <div class="grafico grafico-sexo">
                <canvas id="graficoSexo"></canvas>
            </div>
    
            <div class="grafico grafico-ministerio">
                <canvas id="graficoMinisterio"></canvas>
            </div>
        
            <div class="grafico grafico-total-membros">
                <div class="card-title">Total de Membros</div>
                <div class="card-value">
                    <?php echo $totalMembros; ?>
                </div>
            </div>
    </div>

    </div>
    <script>
        // Gráfico por Sexo
        new Chart(document.getElementById('graficoSexo'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($sexoLabels); ?>,
                datasets: [{
                    label: 'Distribuição por Sexo',
                    data: <?php echo json_encode(array_values($sexoData)); ?>,
                    backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            }
        });

        // Gráfico por Ministério
        new Chart(document.getElementById('graficoMinisterio'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($ministerioLabels); ?>,
                datasets: [{
                    label: 'Participação por Ministério',
                    data: <?php echo json_encode($ministerioData); ?>,
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // Define o gráfico de barras como horizontal
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>
</body>
</html>
