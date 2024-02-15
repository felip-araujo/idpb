<?php 

session_start();

// Incluir o arquivo de conexão PDO
require_once '../login/conexao.php';


$email = $_POST['email'];
$senha = $_POST['senha']; 

$query = "SELECT id, nome, email, senha FROM users2 WHERE email=:email AND senha=:senha";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $senha);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $_SESSION['usuario_id'] = $resultado['id'];
    $_SESSION['usuario_nome'] = $resultado['nome']; 
    header("Location: index.php");
} else {
    header("Location: ../login/login.php?erro_de_login=1");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDPB - Igreja Do Povo Brasileiro</title>
</head>
<body>
    <h1>Painel da Liderança</h1>
    <p>Selecione a ação desejada:</p>
    <div class="botoes">
        <button onclick="gerarRelatorio()">Gerar Relatório</button>
        <button onclick="visualizarRelatorio()">Visualizar Relatório</button>
        <button onclick="cadastrarNovoMembro()">Cadastrar Novo Membro</button>
    </div>

    <script>
        function gerarRelatorio() {
            window.location.href = "http://52.1.203.38/idpb/numero_celula.html";
        }

        function visualizarRelatorio() {
            window.location.href = "http://127.0.0.1:8050/";
        }

        function cadastrarNovoMembro() {
            window.location.href = "http://52.1.203.38/idpb/";
        }
    </script>
</body>
</html>

