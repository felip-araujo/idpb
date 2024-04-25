<?php 
include './conexao.php';
$id_usuario = $_POST['id_usuario'] ?? null;
$function_select = $_POST['function_select'] ?? null;

if($id_usuario && $function_select){
    try{
        $add_new_funcao = $pdo->prepare("UPDATE Usuario_Funcoes_X SET ID_Funcao = :function_select WHERE ID_Usuario = :id_usuario");
        $add_new_funcao->bindParam(':id_usuario', $id_usuario);
        $add_new_funcao->bindParam(':function_select', $function_select);
        $add_new_funcao->execute();
        if($add_new_funcao->rowCount() >= 1){
            echo '<p class="alert alert-success">Nova nova função cadastrada com sucesso!</p>'; 
        } else {
            echo '<p class="alert alert-danger">Erro ao cadastrar nova função!</p>';
        }

    } catch(PDOException $e){
        echo "Erro ao capturar os dados: " . $e->getMessage();
    }
}

?>