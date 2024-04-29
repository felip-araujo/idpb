<?php
include './conexao.php';
$id_usuario = $_POST['id_usuario'] ?? NULL;
$function_select = $_POST['function_select'] ?? NULL;

try{
    $insert_new_funcao = $pdo->prepare("INSERT INTO Usuario_Funcoes_X (ID_Usuario, ID_Funcao) VALUES (:id_usuario, :function_select) ");
        $insert_new_funcao->bindParam(':id_usuario', $id_usuario);
        $insert_new_funcao->bindParam(':function_select', $function_select);

        if ($insert_new_funcao->execute()) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Nova função na liderança atribuída com sucesso!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Erro ao atribuir nova função!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        O Usuário já possui essa função!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>';
    }


