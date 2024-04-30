<?php

include 'conexao.php';
try {
    
    $qr1 = $pdo->prepare("SELECT ID_Funcao FROM Usuario_Funcoes_X WHERE ID_Usuario = :id_usuario");
    $qr1->bindParam(':id_usuario', $_SESSION['id']);
    $qr1->execute();
    $rt = $qr1->fetchAll(PDO::FETCH_COLUMN);
    foreach ($rt as $num){
        echo $num;
    }

} catch(PDOException $e){

}


// echo $_SESSION['id'];
// echo $_SESSION['nome'];
// echo $_SESSION['funcao_usuario'];



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
