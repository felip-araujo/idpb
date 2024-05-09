<?php
include 'conexao.php';
try {
    $qr1 = $pdo->prepare(
        "SELECT Funcoes_X.Nome_Funcao
        FROM Usuario_Funcoes_X
        INNER JOIN Funcoes_X ON Usuario_Funcoes_X.ID_Funcao = Funcoes_X.ID_Funcao
        WHERE Usuario_Funcoes_X.ID_Usuario = :id_usuario"
    );
    $qr1->bindParam(':id_usuario', $_SESSION['id']);
    $qr1->execute();
    $rt = $qr1->fetchAll(PDO::FETCH_COLUMN);


    foreach ($rt as $key => $value) {
        $funcoes = $value . ' ● ';
        echo $funcoes;
    }
} catch (PDOException $e) {
}

$nome_completo = $_SESSION['nome'];
$partes_do_nome = explode(' ', $nome_completo);
$primeiro_nome = $partes_do_nome[0];
date_default_timezone_set('America/Manaus');
$hora_atual = date("H");

if ($hora_atual < 12) {
    $saudacao = "Bom dia";
} elseif ($hora_atual < 18) {
    $saudacao = "Boa tarde";
} else {
    $saudacao = "Boa noite";
}
