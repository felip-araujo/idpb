<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="/..assets">
    
    <title>Dashboard</title>
</head>
<body>
    <h1>Painel da Liderança</h1>
    <?php 

    // Iniciar a sessão
    session_start();
    require 'conexao.php';

    // Verificar se os dados do usuário estão na sessão
    if(isset($_SESSION['usuario_email'])) {

        // Mostrar nome e email do usuário
        echo "<p>Email: " . $_SESSION['usuario_email'] . "</p>";

        // Incluir o arquivo de conexão PDO
        require 'conexao.php';

        // Buscar número da célula
        $email = $_SESSION['usuario_email'];
        $query_celula = "SELECT Nome, Celula FROM funcoes WHERE Email=:email";
        $stmt_celula = $pdo->prepare($query_celula);
        $stmt_celula->bindParam(':email', $email);
        $stmt_celula->execute();
        $resultado_celula = $stmt_celula->fetch(PDO::FETCH_ASSOC);

        // Verificar se número da célula foi encontrado
        if ($resultado_celula) {
            echo "<p>Nome: " . $resultado_celula['Nome'] . "</p>"; 
            echo "<p>Número da Célula: " . $resultado_celula['Celula'] . "</p>"; 
        } else {
            echo "<p>Número da Célula não encontrado.</p>";
        }

        // Buscar número da supervisão
        $query_supervisao = "SELECT Celula, Supervisao FROM funcoes WHERE Email=:email LIMIT 1 OFFSET 1";
        $stmt_supervisao = $pdo->prepare($query_supervisao);
        $stmt_supervisao->bindParam(':email', $email);
        $stmt_supervisao->execute();
        $resultado_supervisao = $stmt_supervisao->fetch(PDO::FETCH_ASSOC);

        // Verificar se número da supervisão foi encontrado
        if ($resultado_supervisao) {
            echo "<p>Número da Supervisão: " . $resultado_supervisao['Supervisao'] . "</p>"; 
        } else {
            echo "<p>Número da Supervisão não encontrado.</p>";
        }

        // Buscar número da coordenação
        $query_coordenacao = "SELECT Celula, Coordenacao FROM funcoes WHERE Email=:email LIMIT 1 OFFSET 2";
        $stmt_coordenacao = $pdo->prepare($query_coordenacao);
        $stmt_coordenacao->bindParam(':email', $email);
        $stmt_coordenacao->execute();
        $resultado_coordenacao = $stmt_coordenacao->fetch(PDO::FETCH_ASSOC);

        // Verificar se número da coordenação foi encontrado
        if ($resultado_coordenacao) {
            echo "<'p>Número da Coordenação: " . $resultado_coordenacao['Coordenacao'] . "</p>"; 
        } else {
            echo "<p>Número da Coordenação não encontrado.</p>";
        }

        // Buscar a função do usuário
        $query_funcao = "SELECT Funcao FROM funcoes WHERE Email=:email";
        $stmt_funcao = $pdo->prepare($query_funcao);
        $stmt_funcao->bindParam(':email', $email);
        $stmt_funcao->execute();
        $resultado_funcao = $stmt_funcao->fetch(PDO::FETCH_ASSOC);

        // Verificar se a função foi encontrada
        if ($resultado_funcao) {
            echo "<p>Função: " . $resultado_funcao['Funcao'] . "</p>"; 
        } else {
            echo "<p>Função não encontrada.</p>";
        }

        // Adicionar botões
        echo "<button onclick=\"location.href='http://52.1.203.38/idpb/pagina_logada.php?numero_celula={$resultado_celula['Celula']}'\">Fazer Relatório</button>";
        echo "<button onclick=\"location.href='http://127.0.0.1:8050/'\">Visualizar Relatório</button>";
        echo "<button onclick=\"location.href='http://52.1.203.38/idpb'\">Cadastrar Novo Membro</button>";

    } else {
        
        echo " <script> alert('Usuário não autenticado!'); </script> ";  
        echo " <script>window.location.href = '../login';</script> ";
    }

    ?>
</body>
</html>
