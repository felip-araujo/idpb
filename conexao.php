<?php

$hostname = "127.0.0.1";
$database = "idpb_membros";
$username = "root";
$password = '$Hur3216';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    // Configurar o PDO para lançar exceções em caso de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "";
} catch (PDOException $e) {
    echo "Falha ao conectar ao banco de dados: " . $e->getMessage();
}

// Não é mais necessário verificar a conexão usando $mysqli->connect_errno
// O PDO lança exceções em caso de erros

// Para realizar operações no banco de dados, você pode usar $pdo
// Exemplo de execução de uma consulta:
// $stmt = $pdo->query("SELECT * FROM sua_tabela");
// while ($row = $stmt->fetch()) {
//     // Faça algo com cada linha
// }

// Não se esqueça de fechar a conexão quando não precisar mais dela
// $pdo = null;

?>
