<?
try {
    $stmt = $pdo->query($query);
    $celulas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao executar consulta: " . $e->getMessage();
    exit;
}


// Checa se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Prepara a inserção no banco de dados usando a conexão PDO
        $stmt = $pdo->prepare("INSERT INTO Relatorio_Supervisao (Numero_Celula, Data_Visita, Recepcao_Pontualidade, Quebra_Gelo, Louvor, Edificacao, Compartilhando, Cadeira_Bencao, Observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $_POST['numero_celula']);
        $stmt->bindParam(2, $_POST['data_visita']);
        $stmt->bindParam(3, $_POST['recepcao_pontualidade']);
        $stmt->bindParam(4, $_POST['quebra_gelo']);
        $stmt->bindParam(5, $_POST['louvor']);
        $stmt->bindParam(6, $_POST['edificacao']);
        $stmt->bindParam(7, $_POST['compartilhando']);
        $stmt->bindParam(8, $_POST['cadeira_bencao']);
        $stmt->bindParam(9, $_POST['observacoes']);
        $stmt->execute();
        echo "Relatório adicionado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir dados: " . $e->getMessage();
    }
}

<?php
// Habilitar a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Caminho absoluto para o arquivo de conexão
// require '/opt/bitnami/apache/htdocs/idpb/dashboard/relatorios/conexao.php';
include './conexao.php';

// Verificar se a conexão foi estabelecida
if (!isset($pdo)) {
    die('Falha ao carregar a conexão com o banco de dados.');
}

// Busca os números das células para o número de supervisão 14
$query = "SELECT DISTINCT Numero_Celula FROM Usuarios_X WHERE Numero_Supervisao = 14";
