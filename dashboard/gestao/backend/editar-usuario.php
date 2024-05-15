<?php
include 'conexao.php';
$id_usuario = $_POST['editUserId'] ?? null;

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
        $table .= '<td> <select name="num_celula" id="num_celula" class="form-control">
                <option>Selecione uma célula</option>
            </select> </td>';
        $table .=    "<td>" . htmlspecialchars($dado['Numero_Celula']) . "</td>";
        $table .=    "<td>" . htmlspecialchars($dado['Numero_Supervisao']) . "</td>";
        $table .=    "<td>" . htmlspecialchars($dado['Numero_Coordenacao']) . "</td>";
        // $table .=    '<td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editar_usuario" onclick="editUser(' . $usuario['ID_Usuario'] . ')">Editar</button></td>';
        // $table .=    '<td><button class="btn btn-danger" id="deleteUser" name="deleteUserId" onclick="deleteUser (' . $usuario['ID_Usuario'] . ')">Excluir</button></td>';
        $table .=  '</tr>';
    }

    $table .= '</tbody>';
    $table .= '</table>';

    echo $table;




} catch (PDOException $e) {
}
