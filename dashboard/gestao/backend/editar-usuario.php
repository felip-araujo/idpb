<?php

session_start();
include 'conexao.php';
$id_usuario = $_POST['editUserId'] ?? null;

try {
    $busca_funcao_adm = $pdo->prepare("SELECT * FROM Usuario_Funcoes_X WHERE ID_Usuario = :id_solicitante AND ID_Funcao = 6");
    $busca_funcao_adm->bindParam('id_solicitante', $_SESSION['id']);
    $busca_funcao_adm->execute();

    if ($busca_funcao_adm->rowCount() >= 1) {

        try {
            $buscarcelula = $pdo->prepare("SELECT Numero_Celula FROM Celulas_X");
            $buscarcelula->execute();
            $celulas_ar = $buscarcelula->fetchall(PDO::FETCH_ASSOC);

            $buscar_supervisao = $pdo->prepare("SELECT * FROM Supervisao_X");
            $buscar_supervisao->execute();
            $supervioes = $buscar_supervisao->fetchAll(PDO::FETCH_ASSOC);

            $buscar_coordenacao = $pdo->prepare("SELECT * FROM Coordenacao_X");
            $buscar_coordenacao->execute();
            $coordenacoes = $buscar_coordenacao->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
        }


        try {
            $buscardados = $pdo->prepare("SELECT * FROM Usuarios_X WHERE ID_Usuario = :i");
            $buscardados->bindParam(':i', $id_usuario);
            $buscardados->execute();
            $dados = $buscardados->fetchAll(PDO::FETCH_ASSOC);

            $table = '<table class="table table-dark table-responsive rounded">';
            $table .= '<thead style="margin-bottom: .5rem;">';
            $table .=  '<tr>';
            $table .=    '<th scope="col">Nome:</th>';
            $table .=    '<th scope="col">Email:</th>';
            $table .=    '<th scope="col">Célula:</th>';
            $table .=    '<th scope="col">Supervisao:</th>';
            $table .=    '<th scope="col">Coordenacao:</th>';
            $table .=  '</tr>';
            $table .= '</thead>';
            $table .= '<tbody>';

            foreach ($dados as $dado) {
                $table .=  '<tr>';
                $table .= '<td><input type="text" class="form-control" placeholder="' . htmlspecialchars($dado['Nome'], ENT_QUOTES, 'UTF-8') . '"></td>';
                $table .= '<td><input type="text" class="form-control" placeholder="' . htmlspecialchars($dado['Email'], ENT_QUOTES, 'UTF-8') . '"></td>';


                $options = '';

                foreach ($celulas_ar as $celulas) {
                    $numero_celula = htmlspecialchars($celulas['Numero_Celula']);
                    $options .= '<option value="' . $numero_celula . '">' . $numero_celula . '</option>';
                }

                $table .= '<td>
                    <select name="num_celula" id="num_celula" class="form-control">
                        <option value="">Selecione uma célula</option>
                        ' . $options . '
                    </select>
                   </td>';

                $options_supervisao = '';

                foreach ($supervioes as $supervisao) {
                    $numero_supervisao = htmlspecialchars($supervisao['Numero_Supervisao']);
                    $options_supervisao .= '<option value="' . $numero_supervisao . '">' . $numero_supervisao . '</option>';
                }

                $table .= '<td>
                    <select name="num_supervisao" id="num_supervisao" class="form-control">
                        <option value="">Selecione uma supervisao</option>
                        ' . $options_supervisao . '
                    </select>
                   </td>';

                $options_coordenacao = '';

                foreach ($coordenacoes as $coordenacao) {
                    $numero_coordenacao = htmlspecialchars($coordenacao['Numero_Coordenacao']);
                    $options_coordenacao .= '<option value="' . $numero_coordenacao . '">' . $numero_coordenacao . '</option>';
                }

                $table .= '<td>
                    <select name="num_coordenacao" id="num_coordenacao" class="form-control">
                        <option value="">Selecione uma coordenacao</option>
                        ' . $options_coordenacao . '
                    </select>
                   </td>';
                $table .=    '<td><button class="btn btn-primary" ">Enviar alterações</button></td>';
                $table .=  '</tr>';
            }

            $table .= '</tbody>';
            $table .= '</table>';

            echo $table;
        } catch (PDOException $e) {
        }
    } else { 

        echo '<p class="alert alert-danger text-center">Você não tem permissão. (Solicite a um Administrador do Sistema)</p>'; 

    }
} catch (PDOException $e) {
}
