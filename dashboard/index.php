<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <!-- <link rel="stylesheet" href="/idpb/login/asstes.login/login.css"> -->
    
    
    <title>Dashboard</title>
</head>
<body>
    <h1>Painel da Liderança</h1>
    
    <?php 
    // Iniciar a sessão
    session_start();

    // Verificar se os dados do usuário estão na sessão
    if(isset($_SESSION['usuario_email'])) {
        
        // Mostrar nome, número da célula e email do usuário
        echo "<p>Nome: " . $_SESSION['usuario_nome'] . "</p>";
        echo "<p>Email: " . $_SESSION['usuario_email'] . "</p>";
        
        // Incluir o arquivo de conexão PDO
        require 'conexao.php';

        // Buscar número da célula
        $email = $_SESSION['usuario_email'];
        $query_celula = "SELECT Nome, Celula, Funcao FROM funcoes WHERE Email=:email";
        $stmt_celula = $pdo->prepare($query_celula);
        $stmt_celula->bindParam(':email', $email);
        $stmt_celula->execute();
        $resultado_celula = $stmt_celula->fetch(PDO::FETCH_ASSOC); 

        if($resultado_celula['Funcao'] == null){
            echo "<script> alert('O Usuário não possui uma função ministerial!') </script>";
            echo "<script> window.location.href = '../login';</script>";
        } 

        // Verificar se número da célula foi encontrado
        if ($resultado_celula) {
            $_SESSION['Celula'] = $resultado_celula['Celula'];
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
            echo "<p>Não é Supervisor.</p>";
        }

        // Buscar número da coordenação
        $query_coordenacao = "SELECT Celula, Coordenacao FROM funcoes WHERE Email=:email LIMIT 1 OFFSET 2";
        $stmt_coordenacao = $pdo->prepare($query_coordenacao);
        $stmt_coordenacao->bindParam(':email', $email);
        $stmt_coordenacao->execute();
        $resultado_coordenacao = $stmt_coordenacao->fetch(PDO::FETCH_ASSOC);

        // Verificar se número da coordenação foi encontrado
        if ($resultado_coordenacao) {
            echo "<p>Número da Coordenação: " . $resultado_coordenacao['Coordenacao'] . "</p>"; 
        } else {
            echo "<p>Não é Coordenador.</p>";
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

        // Criar o botão para gerar relatórios com opções para célula, supervisão e coordenação
        echo "<form>";
        echo "<label>Selecione uma opção para gerar o relatório:</label><br>";
        echo "<select name='tipo_relatorio' id='tipo_relatorio'>"; 
        if ($resultado_celula && $resultado_celula['Celula'] !== null) {
            echo "<option value='celula'>Célula " . $resultado_celula['Celula'] . "</option>";
        }
        if ($resultado_supervisao && $resultado_supervisao['Supervisao'] !== null) {
            echo "<option value='supervisao'>Supervisão " . $resultado_supervisao['Supervisao'] . "</option>";
        }
        if ($resultado_coordenacao && $resultado_coordenacao['Coordenacao'] !== null) {
            echo "<option value='coordenacao'>Coordenação " . $resultado_coordenacao['Coordenacao'] . "</option>";
        }
        echo "</select><br>";
        echo "<button type='button' onclick='gerarRelatorio()'>Gerar Relatório</button>";
        echo "</form>";

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
        
        // Outros botões
        echo "<button onclick=\"location.href='http://127.0.0.1:8050/'\">Visualizar Relatório</button>";
        echo "<button onclick=\"location.href='http://52.1.203.38/idpb/cadastro'\">Cadastrar Novo Membro</button>";
    
    } else {
        // Iniciar sessão antes do redirecionamento
        
        session_start();
        echo "<script>alert('Usuário não autenticado!')</script>";
        echo "<script>window.location.href = '../login';</script>";
    } 

    ?> 
</body>
</html>
