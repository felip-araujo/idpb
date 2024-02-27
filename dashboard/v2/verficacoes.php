<?php 

require_once '../conexao.php'; 


session_start();
        if (isset($_SESSION['usuario_email'])) {
            
            $nome = $_SESSION['usuario_nome']; 
            $primeiroNome = explode(' ', $nome)[0]; 
            
        }


// Buscar número da célula
$email = $_SESSION['usuario_email'];
$query_celula = "SELECT Nome, Celula, Funcao FROM funcoes WHERE Email=:email";
$stmt_celula = $pdo->prepare($query_celula);
$stmt_celula->bindParam(':email', $email);
$stmt_celula->execute();
$resultado_celula = $stmt_celula->fetch(PDO::FETCH_ASSOC); 

//Verificar se o  usuário tem uma função
if($resultado_celula['Funcao'] == null){
    echo "<script> alert('O Usuário não possui uma função ministerial!') </script>";
    echo "<script> window.location.href = '/idpb/login';</script>";
} else{
    $funcao = $resultado_celula['Funcao'];
}

// Verificar se número da célula foi encontrado
if ($resultado_celula) {
    $_SESSION['Celula'] = $resultado_celula['Celula'];  
    $numero_celula = $resultado_celula['Celula'];
} else {
    echo "<p>Número da Célula não encontrado.</p>"; 
} 


?>