<?php
require '/opt/bitnami/apache/htdocs/idpb/dashboard/relatorios/conexao.php';

// Verificar se o método POST foi usado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar dados do formulário
    $numeroCelula = $_POST['numero_celula'];
    $dataVisita = $_POST['data_visita'];
    $recepcaoPontualidade = $_POST['recepcao_e_pontualidade'];
    $quebraGelo = $_POST['quebra_gelo'];
    $louvor = $_POST['louvor'];
    $edificacao = $_POST['edificacao'];
    $compartilhando = $_POST['compartilhando'];
    $cadeiraBencao = $_POST['cadeira_da_bencao'];
    $observacoes = $_POST['observacoes'];

    // Preparar a consulta SQL
    $query = "INSERT INTO Relatorio_Supervisao (Numero_Celula, Data_Visita, Recepcao_Pontualidade, Quebra_Gelo, Louvor, Edificacao, Compartilhando, Cadeira_Bencao, Observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);

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
