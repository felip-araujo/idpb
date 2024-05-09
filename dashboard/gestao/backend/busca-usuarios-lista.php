<?php
include './conexao.php';
try {
    $usuarios = $pdo->query("
    SELECT Usuarios_X.ID_Usuario, Usuarios_X.Nome, GROUP_CONCAT(Funcoes_X.Nome_Funcao SEPARATOR ' | ') AS Funcoes
    FROM Usuarios_X
    LEFT JOIN Usuario_Funcoes_X ON Usuarios_X.ID_Usuario = Usuario_Funcoes_X.ID_Usuario
    LEFT JOIN Funcoes_X ON Usuario_Funcoes_X.ID_Funcao = Funcoes_X.ID_Funcao
    GROUP BY Usuarios_X.ID_Usuario, Usuarios_X.Nome;
    
    ")->fetchAll(PDO::FETCH_ASSOC);

    $table = '<table class="table table-dark rounded">';
    $table .= '<thead style="margin-bottom: .5rem;">';
    $table .=  '<tr>';
    $table .=    '<th scope="col">ID:</th>';
    $table .=    '<th scope="col">Nome:</th>';
    $table .=    '<th scope="col">Função:</th>';
    $table .=    '<th scope="col">Ação:</th>';
    $table .=    '<th scope="col">Ação:</th>';
    $table .=  '</tr>';
    $table .= '</thead>';
    $table .= '<tbody>';

    foreach ($usuarios as $key => $usuario) {
        $table .=  '<tr>';
        $table .=    "<td>" . htmlspecialchars($usuario['ID_Usuario']) . "</td>";
        $table .=    "<td>" . htmlspecialchars($usuario['Nome']) . "</td>";
        $table .=    "<td>" . htmlspecialchars($usuario['Funcoes']) . "</td>";
        $table .=    '<td><button class="btn btn-primary" onclick="editUser(' . $usuario['ID_Usuario'] . ')">Editar</button></td>';
        $table .=    '<td><button class="btn btn-danger" id="deleteUser" name="deleteUserId" onclick="deleteUser (' . $usuario['ID_Usuario'] . ')">Excluir</button></td>';
        $table .=  '</tr>';
    }

    $table .= '</tbody>';
    $table .= '</table>';

    echo $table;
} catch (PDOException $e) {
}
