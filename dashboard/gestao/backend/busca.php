<?php 
include './conexao.php';
try {
    // Consultas para buscar os dados
    $usuarios = $pdo->query("SELECT ID_Usuario, Nome FROM Usuarios_X")->fetchAll(PDO::FETCH_ASSOC);
    $funcoes = $pdo->query("SELECT ID_Funcao, Nome_Funcao FROM Funcoes_X")->fetchAll(PDO::FETCH_ASSOC);

    $options = "";
    foreach($usuarios as $usuario){
        $options .= "<option value='" . $usuario['ID_Usuario'] . "'>" . htmlspecialchars($usuario['Nome']) . "</option>"; 
    }
    echo $options;


} catch (PDOException $e) {
    echo "<option> Erro ao carregar usuários " . $e->getMessage() . "</option>";  
}
?>
