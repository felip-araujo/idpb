<?php

$hostname = "54.196.208.38";
$database = "IDPB";
$username = "root";
$password = "qiykGUao3R.D";

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    // Configurar o PDO para lançar exceções em caso de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Falha ao conectar ao banco de dados: " . $e->getMessage();
} 

//https://tresdevs.com.br/idpb/analise_dados/php_teste/index.php
?>
