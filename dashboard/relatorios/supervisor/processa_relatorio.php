<?php
// Habilitar a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Caminho absoluto para o arquivo de conexão
require '/opt/bitnami/apache/htdocs/idpb/dashboard/relatorios/conexao.php';

// Verificar se a página foi acessada com um POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar dados do formulário
    $numeroCelula = isset($_POST['numero_celula']) ? $_POST['numero_celula'] : null;
    $dataVisita = isset($_POST['data_visita']) ? $_POST['data_visita'] : null;
    $recepcaoPontualidade = isset($_POST['recepcao_pontualidade']) ? $_POST['recepcao_pontualidade'] : null;
    $quebraGelo = isset($_POST['quebra_gelo']) ? $_POST['quebra_gelo'] : null;
    $louvor = isset($_POST['louvor']) ? $_POST['louvor'] : null;
    $edificacao = isset($_POST['edificacao']) ? $_POST['edificacao'] : null;
    $compartilhando = isset($_POST['compartilhando']) ? $_POST['compartilhando'] : null;
    $cadeiraBencao = isset($_POST['cadeira_da_bencao']) ? $_POST['cadeira_da_bencao'] : null;
    $observacoes = isset($_POST['observacoes']) ? $_POST['observacoes'] : '';

    // Sanitização dos dados
    $observacoes = htmlspecialchars($observacoes, ENT_QUOTES, 'UTF-8');

    // Preparar a inserção no banco de dados
    $query = "INSERT INTO Relatorio_Supervisao (Numero_Celula, Data_Visita, Recepcao_Pontualidade, Quebra_Gelo, Louvor, Edificacao, Compartilhando, Cadeira_Bencao, Observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);

    try {
        // Executar a inserção
        $stmt->execute([
            $numeroCelula,
            $dataVisita,
            $recepcaoPontualidade,
            $quebraGelo,
            $louvor,
            $edificacao,
            $compartilhando,
            $cadeiraBencao,
            $observacoes
        ]);
        // Redirecionar para uma página de sucesso ou exibir uma mensagem
        echo "Relatório adicionado com sucesso!";
    } catch (PDOException $e) {
        // Tratar e exibir erro
        die("Erro ao inserir dados no banco: " . $e->getMessage());
    }
} else {
    // Se não foi um POST, redirecionar de volta ao formulário ou a outra página
    header('Location: formulario_de_visita.html'); // Ajuste o nome do arquivo conforme necessário
    exit;
}
?>
