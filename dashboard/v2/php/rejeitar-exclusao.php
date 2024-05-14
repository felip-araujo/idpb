<?php 
include 'conexao.php';
$id = $_POST['id'] ?? null;
$rejeitar = $pdo->prepare("UPDATE Solicitacoes_Exclusao_X SET aprovado = null WHERE id = :i");
$rejeitar->bindParam(':i', $id);
if($rejeitar->execute()){
    echo "Solicitação Rejeitada!O Usuario ainda faz parte do Sistema!";
}