<?php 

require_once '../conexao.php'; 


session_start();
        if (isset($_SESSION['usuario_email'])) {
            
            $nome = $_SESSION['usuario_nome']; 
            $primeiroNome = explode(' ', $nome)[0]; 
            
        }


// Buscar número da célula
$email = $_SESSION['usuario_email'];
$query_celula = "SELECT Nome, Celula, Funcao, Email, Supervisao, Coordenacao FROM funcoes WHERE Email=:email";
$stmt_celula = $pdo->prepare($query_celula);
$stmt_celula->bindParam(':email', $email);
$stmt_celula->execute();
$resultado_celula = $stmt_celula->fetch(PDO::FETCH_ASSOC);   


if (!$resultado_celula){
    echo " erro ";
} else {
    var_dump($resultado_celula);
}

//Verificar se o  usuário tem uma função
if($resultado_celula['Funcao'] == null){
    echo "<script> alert('O Usuário não possui uma função ministerial!') </script>";
    
} else {
    $funcao = $resultado_celula['Funcao'];  
    
} 

// Verificar se número da célula foi encontrado
if ($resultado_celula) {
    $_SESSION['Celula'] = $resultado_celula['Celula'];  
    $numero_celula = $resultado_celula['Celula'];
} else {
    echo "<p>Número da Célula não encontrado.</p>"; 
}  


// JavaScript para redirecionar com base na opção selecionada
echo "<script>";
echo "function gerarRelatorio() {";
echo "  var tipo = document.getElementById('tipo_relatorio').value;";
echo "  if (tipo === 'celula') {";
echo "    window.location.href = 'pagina_logada.php';";
echo "  } else if (tipo === 'supervisao') {";
echo "    window.location.href = 'gerar_relatorio_supervisao.php';";
echo "  } else if (tipo === 'coordenacao') {";
echo "    window.location.href = 'gerar_relatorio_coordenacao.php';";
echo "  }";
echo "}";
echo "</script>";
