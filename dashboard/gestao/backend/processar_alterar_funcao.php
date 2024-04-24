<?php
ob_start(); // Ativamos o buffer de saída no início do script

// Asseguramos que a sessão é iniciada antes de qualquer saída
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'conexao.php';

$response = [];

if (isset($_POST['enviar'])) {
    $usuario = $_POST['usuario'];
    $nova_funcao = $_POST['nova_funcao'];

    $usuario = $_POST['usuario'];
    $nova_funcao = $_POST['nova_funcao'];

     $busca_id  = $pdo->prepare("SELECT ID_Usuario FROM  Usuarios_X WHERE Nome = :nome");
    $busca_id->bindParam(':nome', $usuario, PDO::PARAM_STR);
    $busca_id->execute();
    $retorno_id = $busca_id->fetch(PDO::FETCH_ASSOC);
    $id_usuario = $retorno_id['ID_Usuario'];

    $busca_id_funcao = $pdo->prepare("SELECT ID_Funcao FROM Funcoes_X WHERE Nome_Funcao = :nova_funcao");
    $busca_id_funcao->bindParam(':nova_funcao', $nova_funcao, PDO::PARAM_STR);
    $busca_id_funcao->execute();
    $retorno_id_funcao = $busca_id_funcao->fetch(PDO::FETCH_ASSOC);
    $id_funcao = $retorno_id_funcao['ID_Funcao'];

    $alterar = $pdo->prepare("UPDATE Usuario_Funcoes_X SET ID_Funcao = :id_funcao WHERE ID_Usuario = :id_usuario");
    $alterar->bindParam(':id_funcao', $id_funcao);
    $alterar->bindParam(':id_usuario', $id_usuario);

    if ($alterar->execute()) {

        
        $_SESSION['mensagem'] = $mensagem;
        echo '<script>alert("Função atualizada com sucesso!")</script>';
        echo "<script>window.location.href='../dashboard/v2/dashboard.php'";


        // $response['message'] = 'Função atualizada com Sucesso!';
        // $mensagem = '<div class="alert alert-success">Função atualizada com Sucesso</div>';
        

    } else {
        $response['error'] = 'Erro na solicitação, contate o administrador!';
    }
} else {
    $response['error'] = 'Nenhum dado enviado.';
}

// header('Content-Type: application/json');
echo json_encode($response);
ob_end_flush(); // Limpa o buffer e envia a saída acumulada para o navegador
exit; // Finaliza a execução do script após enviar a resposta
?>

 
