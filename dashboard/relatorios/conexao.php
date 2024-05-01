<?php
$hostname = "108.167.151.34"; // Endereço do servidor MySQL
$database = "evolud85_idpb"; // Nome do banco de dados
$username = "evolud85_chris"; // Nome de usuário
$password = 'vGT{R_A^-E+4'; // Senha

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    // Configurar o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão estabelecida com sucesso!";
} catch (PDOException $e) {
    die("Falha ao conectar ao banco de dados: " . $e->getMessage());
}
?>
