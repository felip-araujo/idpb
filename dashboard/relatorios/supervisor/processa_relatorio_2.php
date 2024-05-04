<?php
require '/opt/bitnami/apache/htdocs/idpb/dashboard/relatorios/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extrair Numero_Celula e Nome_Lider
    list($numeroCelula, $nomeLider) = explode('|', $_POST['lider_info'], 2);
    $dataVisita = $_POST['data_visita'];
    $necessidadesDetectadas = $_POST['necessidades_detectadas'];
    $motivosOracao = $_POST['motivos_oracao'];
    $outrasObservacoes = $_POST['outras_observacoes'];

    // Prepare a consulta SQL
    $stmt = $pdo->prepare("INSERT INTO Relatorio_Supervisao_2 (Numero_Celula, Nome_Lider, Data_Visita, Necessidades_Detectadas, Motivos_Oracao, Outras_Observacoes) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Executar a consulta
    try {
        $stmt->execute([$numeroCelula, $nomeLider, $dataVisita, $necessidadesDetectadas, $motivosOracao, $outrasObservacoes]);
        echo "Relatório adicionado com sucesso!";
    } catch (PDOException $e) {
        die("Erro ao inserir o relatório: " . $e->getMessage());
    }
} else {
    echo "Método inválido.";
}
?>
