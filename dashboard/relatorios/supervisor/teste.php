<?php
// Incluir o arquivo de conexão
include 'conexao.php';

// Verificar se a conexão foi estabelecida
if (!isset($pdo)) {
    die('Falha ao carregar a conexão com o banco de dados.');
}

// Testar a conexão fazendo uma consulta simples
try {
    $consulta = $pdo->query("SELECT 1");
    $resultado = $consulta->fetchAll();
    if (count($resultado) > 0) {
        echo "Conexão com o banco de dados funcionando corretamente.";
    } else {
        echo "A conexão está ativa, mas a consulta não retornou dados.";
    }
} catch (PDOException $e) {
    echo "Erro ao executar consulta: " . $e->getMessage();
}
?>
