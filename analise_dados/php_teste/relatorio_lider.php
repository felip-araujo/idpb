<?php
session_start();
include 'conexao.php';

// Função de debug para mostrar erros
function debug($msg) {
    echo "<pre>";
    print_r($msg);
    echo "</pre>";
}

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

// Tenta buscar as informações na tabela usuarios
try {
    $stmt = $pdo->prepare("SELECT u.numero_celula, u.numero_coordenacao, u.numero_supervisao, u.nome
                           FROM usuarios u
                           WHERE u.email = :email");



    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $membro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($membro) {
        // Se encontrou o membro, define as variáveis
        $numero_celula = $membro['numero_celula'];
        $coordenacao = $membro['numero_coordenacao'];
        $lider = $membro['nome'];

        // Conta o total de membros na célula
        $stmt = $pdo->prepare("SELECT COUNT(*) as total_membros FROM membros WHERE numero_celula = :numero_celula");
        $stmt->bindParam(':numero_celula', $numero_celula);
        $stmt->execute();
        $total_membros = $stmt->fetch(PDO::FETCH_ASSOC)['total_membros'];
    } else {
        // Se não encontrou, mostra mensagem de erro
        debug("Erro ao buscar informações do membro.");
        exit();
    }
} catch (Exception $e) {
    // Mostra o erro em caso de falha na consulta
    debug($e->getMessage());
    exit();
}

// Se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Coleta os dados do formulário
        $data = $_POST['data'];
        $convertidos = isset($_POST['houve_conversao']) ? 1 : 0;
        $email_convertido = $_POST['email_convertido'] ?? null;
        $telefone_convertido = $_POST['telefone_convertido'] ?? null;
        $evento = isset($_POST['foi_evento']) ? 1 : 0;
        $nome_evento = $_POST['qual_evento'] ?? null;
        $criancas_presentes = $_POST['criancas_presentes'] ?? 0;
        $coordenador_presente = isset($_POST['coordenador_presente']) ? 1 : 0;
        $supervisor_presente = isset($_POST['supervisor_presente']) ? 1 : 0;

        // Insere o relatório na tabela relatorio_lider
        $stmt = $pdo->prepare("INSERT INTO relatorio_lider 
                               (data, convertidos, email_convertido, telefone_convertido, evento, nome_evento, criancas, coordenador_presente, supervisor_presente) 
                               VALUES (:data, :convertidos, :email_convertido, :telefone_convertido, :evento, :nome_evento, :criancas_presentes, :coordenador_presente, :supervisor_presente)");
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':convertidos', $convertidos);
        $stmt->bindParam(':email_convertido', $email_convertido);
        $stmt->bindParam(':telefone_convertido', $telefone_convertido);
        $stmt->bindParam(':evento', $evento);
        $stmt->bindParam(':nome_evento', $nome_evento);
        $stmt->bindParam(':criancas_presentes', $criancas_presentes);
        $stmt->bindParam(':coordenador_presente', $coordenador_presente);
        $stmt->bindParam(':supervisor_presente', $supervisor_presente);
        $stmt->execute();

        // Insere a lista de presença na tabela presencas
        if (isset($_POST['presenca'])) {
            foreach ($_POST['presenca'] as $cpf => $presente) {
                $stmt = $pdo->prepare("INSERT INTO presencas (numero_celula, cpf, data, presente) VALUES (:numero_celula, :cpf, :data, :presente)");
                $stmt->bindParam(':numero_celula', $numero_celula);
                $stmt->bindParam(':cpf', $cpf);
                $stmt->bindParam(':data', $data);
                $stmt->bindParam(':presente', $presente);
                $stmt->execute();
            }
        }

        // Se chegou até aqui, exibe mensagem de sucesso
        debug("Relatório enviado com sucesso!");
    } catch (Exception $e) {
        // Mostra o erro em caso de falha no envio do formulário
        debug($e->getMessage());
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório do Líder</title>
</head>
<body>
    <!-- Informações da célula e líder -->
    <h1>Célula <?php echo htmlspecialchars($numero_celula); ?> - Coordenação <?php echo htmlspecialchars($coordenacao); ?></h1>
    <h2>Líder: <?php echo htmlspecialchars($lider); ?></h2>
    <h3>Total de membros: <?php echo htmlspecialchars($total_membros); ?></h3>

    <!-- Formulário para envio do relatório -->
    <form method="post">
        <label for="data">Selecione a data da célula:</label>
        <input type="date" id="data" name="data" required><br><br>

        <label>Houve alguma conversão?</label><br>
        <input type="radio" id="houve_conversao_sim" name="houve_conversao" value="1">
        <label for="houve_conversao_sim">Sim</label>
        <input type="radio" id="houve_conversao_nao" name="houve_conversao" value="0">
        <label for="houve_conversao_nao">Não</label><br>

        <!-- Campo condicional para novos convertidos -->
        <div id="convertidos" style="display: none;">
            <label for="email_convertido">Digite aqui o email do novo convertido:</label>
            <input type="email" id="email_convertido" name="email_convertido"><br>
            <label for="telefone_convertido">Digite aqui o telefone do novo convertido:</label>
            <input type="text" id="telefone_convertido" name="telefone_convertido"><br>
        </div><br>

        <label>Foi um evento?</label><br>
        <input type="radio" id="foi_evento_sim" name="foi_evento" value="1">
        <label for="foi_evento_sim">Sim</label>
        <input type="radio" id="foi_evento_nao" name="foi_evento" value="0">
        <label for="foi_evento_nao">Não</label><br>

        <!-- Campo condicional para nome do evento -->
        <div id="evento" style="display: none;">
            <label for="qual_evento">Digite qual:</label>
            <input type="text" id="qual_evento" name="qual_evento"><br>
        </div><br>

        <!-- Lista de presença dos membros -->
        <h3>Lista de presença</h3>
        <?php
        try {
            // Busca a lista de membros da célula
            $stmt = $pdo->prepare("SELECT nome_completo, cpf FROM membros WHERE numero_celula = :numero_celula");
            $stmt->bindParam(':numero_celula', $numero_celula);
            $stmt->execute();
            $membros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Exibe os membros com checkbox para marcar presença
            foreach ($membros as $membro) {
                echo '<label>' . htmlspecialchars($membro['nome_completo']) . '</label>';
                echo '<input type="checkbox" name="presenca[' . htmlspecialchars($membro['cpf']) . ']" value="1"><br>';
            }
        } catch (Exception $e) {
            debug($e->getMessage());
            exit();
        }
        ?><br>

        <!-- Campos para outras informações -->
        <label for="criancas_presentes">Quantidade de crianças presentes:</label>
        <input type="number" id="criancas_presentes" name="criancas_presentes" min="0"><br><br>

        <label>Coordenador estava presente?</label>
        <input type="checkbox" id="coordenador_presente" name="coordenador_presente" value="1"><br>

        <label>Supervisor estava presente?</label>
        <input type="checkbox" id="supervisor_presente" name="supervisor_presente" value="1"><br><br>

        <button type="submit">Enviar Relatório</button>
    </form>

    <!-- Script para mostrar/ocultar campos condicionalmente -->
    <script>
        document.querySelector('input[name="houve_conversao"]').addEventListener('change', function () {
            document.getElementById('convertidos').style.display = this.value == '1' ? 'block' : 'none';
        });

        document.querySelector('input[name="foi_evento"]').addEventListener('change', function () {
            document.getElementById('evento').style.display = this.value == '1' ? 'block' : 'none';
        });
    </script>
</body>
</html>
