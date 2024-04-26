<?php 
include './conexao.php';
try {
    // Consultas para buscar os dados
    
    $funcoes = $pdo->query("SELECT ID_Funcao, Nome_Funcao FROM Funcoes_X")->fetchAll(PDO::FETCH_ASSOC);

    $options = "";
    foreach($funcoes as $Funcao){
        $options .= "<option value='" . $Funcao['ID_Funcao'] . "'>" . htmlspecialchars($Funcao['Nome_Funcao']) . "</option>"; 
    }
    echo $options;


} catch (PDOException $e) {
    echo "<option> Erro ao carregar usuários " . $e->getMessage() . "</option>";   
}
?>
