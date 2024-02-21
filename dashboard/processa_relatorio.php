<?php
require 'conexao.php';

session_start();
$Celula = $_SESSION['Celula'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se 'data_relatorio' está definido em $_POST antes de acessá-lo
    $data_relatorio = isset($_POST['data_relatorio']) ? $_POST['data_relatorio'] : null;

    $conversao = isset($_POST['conversao']) ? 1 : 0;
    $evento = isset($_POST['evento']) ? 1 : 0;
    $presenca = isset($_POST['presenca']) ? $_POST['presenca'] : array();

    // Obter todos os membros da célula para garantir que todos sejam considerados
    $query = "SELECT nome_completo FROM membros WHERE numero_celula = :Celula";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':Celula', $Celula);
    $stmt->execute();
    // Incluir o número da célula na inserção do banco de dados
    $todos_membros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Preparar e executar a inserção dos dados do relatório
    try {
        $stmt = $pdo->prepare("INSERT INTO frequencia (numero_celula, data_relatorio, conversao, evento, nome_completo, presente) VALUES (:Celula, :data_relatorio, :conversao, :evento, :nome_completo, :presente)");

        // Bind do parâmetro fora do loop
        $stmt->bindParam(':Celula', $Celula);
        $stmt->bindParam(':data_relatorio', $data_relatorio);
        $stmt->bindParam(':conversao', $conversao);
        $stmt->bindParam(':evento', $evento);

        // Iterar sobre todos os membros, marcando-os como presentes ou ausentes
        foreach ($todos_membros as $membro) {
            // Se o membro estiver presente, presente = 1; senão, presente = 0
            $presente = in_array($membro['nome_completo'], $presenca) ? 1 : 0;

            // Bind do parâmetro do membro dentro do loop
            $stmt->bindParam(':nome_completo', $membro['nome_completo']);
            $stmt->bindParam(':presente', $presente);
            $stmt->execute();
        }

        echo "Relatório de presença enviado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir no banco de dados: " . $e->getMessage();
    }
} else {
    echo "Método inválido";
}
?>
