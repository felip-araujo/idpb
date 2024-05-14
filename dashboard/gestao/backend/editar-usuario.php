<?php
include 'conexao.php';
$id_usuario = $_POST['editUserId'] ?? null;

try {
    $buscardados = $pdo->prepare("SELECT * FROM Usuarios_X WHERE ID_Usuario = :i"); 
    $buscardados->bindParam(':i', $id_usuario);
    $buscardados->execute();
    $dados = $buscardados->fetch(PDO::FETCH_ASSOC); 

    echo $dados['Email'];
    var_dump($dados);
} catch (PDOException $e) {
}
