<?php
require '/opt/bitnami/apache/htdocs/idpb/dashboard/relatorios/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroCelula = $_POST['numero_celula'];
    $necessidadesDetectadas = $_POST['necessidades_detectadas'];
    $motivosOracao = $_POST['motivos_oracao'];
    $outrasObservacoes = $_POST['outras_observacoes'];

    // Preparar a inserção no banco de dados
    $stmt = $pdo->prepare("INSERT INTO Relatorio_Supervisao_2 (Numero_Celula, Nome_Lider, Necessidades_Detectadas, Motivos_Oracao, Outras_Observacoes) VALUES (?, (SELECT Nome_Lider FROM ViewCelulasInfo WHERE Numero_Celula = ?), ?, ?, ?)");
    
    try {
        $stmt->execute([$numeroCelula, $numeroCelula, $necessidadesDetectadas, $motivosOracao, $outrasObservacoes]);
        echo "Relatório adicionado com sucesso!";
    } catch (PDOException $e) {
        die("Erro ao inserir o relatório: " . $e->getMessage());
    }
} else {
    echo "Método inválido.";
}
?>
