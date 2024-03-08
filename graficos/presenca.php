<?php
// Iniciar a sessão
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Presença dos Membros da Célula <?php echo isset($_SESSION['Celula']) ? $_SESSION['Celula'] : ''; ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<h2>Presença dos Membros da Célula <?php echo isset($_SESSION['Celula']) ? $_SESSION['Celula'] : ''; ?></h2>

<table>
    <tr>
        <th>Data do Relatório</th>
        <th>Nome Completo</th>
        <th>Presente</th>
    </tr>

    <?php
    // Verificar se o número da célula está presente na sessão
    if(isset($_SESSION['Celula'])) {
        // Armazenar o número da célula na variável $numero_celula
        $numero_celula = $_SESSION['Celula'];

        // Incluir o arquivo de conexão
        include 'conexao.php';

        try {
            // Consulta SQL para recuperar os nomes, datas e presença dos relatórios para a célula especificada
            $sql = "SELECT data_relatorio, nome_completo, presente FROM frequencia WHERE numero_celula = '70' ORDER BY data_relatorio";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$numero_celula]);

            $last_date = null; // Variável para rastrear a última data

            if ($stmt->rowCount() > 0) {
                // Exibir os dados em cada linha da tabela
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['data_relatorio'] !== $last_date) {
                        // Se a data for diferente da última, exibe uma linha separadora e a data
                        echo "<tr class='date-separator'><td colspan='3'>" . $row['data_relatorio'] . "</td></tr>";
                        $last_date = $row['data_relatorio'];
                    }

                    echo "<tr>";
                    echo "<td></td>"; // Coluna vazia para alinhar com as outras colunas
                    echo "<td>" . $row['nome_completo'] . "</td>";
                    echo "<td>" . ($row['presente'] == 1 ? 'Sim' : 'Não') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Nenhum dado encontrado</td></tr>";
            }
        } catch (PDOException $e) {
            echo "Erro ao executar a consulta: " . $e->getMessage();
        }
    } else {
        echo "<tr><td colspan='3'>Número da célula não encontrado na sessão.</td></tr>";
    }
    ?>

</table>

</body>
</html>
