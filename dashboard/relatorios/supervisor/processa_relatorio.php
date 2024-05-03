<?php
require '/opt/bitnami/apache/htdocs/idpb/dashboard/relatorios/conexao.php';

// Verificar se o método POST foi usado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar dados do formulário
    $numeroCelula = $_POST['numero_celula'];
    $dataVisita = $_POST['data_visita'];
    // Coletar dados do formulário
    $recepcaoPontualidade = $_POST['Recepcao_Pontualidade'] ?? null;
    $quebraGelo = $_POST['Quebra_Gelo'] ?? null;
    $louvor = $_POST['Louvor'] ?? null;
    $edificacao = $_POST['Edificacao'] ?? null;
    $compartilhando = $_POST['Compartilhando'] ?? null;
    $cadeiraBencao = $_POST['Cadeira_Bencao'] ?? null;
    $observacoes = $_POST['observacoes'];

    $stmt = $pdo->prepare("INSERT INTO Relatorio_Supervisao (Recepcao_Pontualidade, Quebra_Gelo, Louvor, Edificacao, Compartilhando, Cadeira_Bencao, Observacoes) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$recepcaoPontualidade, $quebraGelo, $louvor, $edificacao, $compartilhando, $cadeiraBencao, $observacoes]);
    

    // Executar a consulta
    try {
        $stmt->execute([$numeroCelula, $dataVisita, $recepcaoPontualidade, $quebraGelo, $louvor, $edificacao, $compartilhando, $cadeiraBencao, $observacoes]);
        echo "Relatório adicionado com sucesso!";
    } catch (PDOException $e) {
        die("Erro ao inserir o relatório: " . $e->getMessage());
    }
} else {
    // Não é POST
    echo "Método inválido.";
}
?>
