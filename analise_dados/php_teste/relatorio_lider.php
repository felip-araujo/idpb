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
        $data_reuniao = $_POST['data_reuniao'];
        $celula = $numero_celula;
        $visitantes = isset($_POST['houve_visitante']) ? 1 : 0;
        $numero_visitantes = isset($_POST['numero_visitantes']) && $_POST['numero_visitantes'] !== '' ? (int)$_POST['numero_visitantes'] : null;
        $convertidos = isset($_POST['houve_conversao']) ? 1 : 0;
        $numero_convertidos = isset($_POST['numero_convertidos']) && $_POST['numero_convertidos'] !== '' ? (int)$_POST['numero_convertidos'] : null;
        $evento = isset($_POST['foi_evento']) ? 1 : 0;
        $nome_evento = $_POST['qual_evento'] ?? null;
        $criancas_presentes = isset($_POST['criancas_presentes']) && $_POST['criancas_presentes'] !== '' ? (int)$_POST['criancas_presentes'] : null;
        $coordenador_presente = isset($_POST['coordenador_presente']) ? 1 : 0;
        $supervisor_presente = isset($_POST['supervisor_presente']) ? 1 : 0;
        $observacoes = $_POST['observacoes'] ?? null;

        // Insere o relatório na tabela relatorio_lider
        $stmt = $pdo->prepare("INSERT INTO relatorio_lider 
                               (data, celula, visitantes, numero_visitantes, convertidos, numero_convertidos, evento, nome_evento, criancas, coordenador_presente, supervisor_presente, observacoes) 
                               VALUES (:data_reuniao, :celula, :visitantes, :numero_visitantes, :convertidos, :numero_convertidos, :evento, :nome_evento, :criancas_presentes, :coordenador_presente, :supervisor_presente, :observacoes)");
        $stmt->bindParam(':data_reuniao', $data_reuniao);
        $stmt->bindParam(':celula', $numero_celula);
        $stmt->bindParam(':visitantes', $visitantes);
        $stmt->bindParam(':numero_visitantes', $numero_visitantes);
        $stmt->bindParam(':convertidos', $convertidos);
        $stmt->bindParam(':numero_convertidos', $numero_convertidos);
        $stmt->bindParam(':evento', $evento);
        $stmt->bindParam(':nome_evento', $nome_evento);
        $stmt->bindParam(':criancas_presentes', $criancas_presentes);
        $stmt->bindParam(':coordenador_presente', $coordenador_presente);
        $stmt->bindParam(':supervisor_presente', $supervisor_presente);
        $stmt->bindParam(':observacoes', $observacoes);
        $stmt->execute();

        // Insere a lista de presença na tabela presencas
        if (isset($_POST['presenca'])) {
            foreach ($_POST['presenca'] as $cpf => $presente) {
                $stmt = $pdo->prepare("INSERT INTO presencas (numero_celula, cpf, data, presente) VALUES (:numero_celula, :cpf, :data_reuniao, :presente)");
                $stmt->bindParam(':numero_celula', $numero_celula);
                $stmt->bindParam(':cpf', $cpf);
                $stmt->bindParam(':data_reuniao', $data_reuniao);
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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório da Célula</title>
</head>
<body>
    <h2>Relatório da Célula</h2>
    <form method="post">
        <label for="data_reuniao">Data da reunião:</label>
        <input type="date" id="data_reuniao" name="data_reuniao" required><br><br>

        <label>Houve conversão?</label><br>
        <input type="radio" id="houve_conversao_sim" name="houve_conversao" value="1">
        <label for="houve_conversao_sim">Sim</label>
        <input type="radio" id="houve_conversao_nao" name="houve_conversao" value="0">
        <label for="houve_conversao_nao">Não</label><br>

        <!-- Campo condicional para o número de convertidos -->
        <div id="convertidos" style="display: none;">
            <label for="numero_convertidos">Número de convertidos:</label>
            <input type="number" id="numero_convertidos" name="numero_convertidos"><br>
        </div><br>

        <label>Houve visitante?</label><br>
        <input type="radio" id="houve_visitante_sim" name="houve_visitante" value="1">
        <label for="houve_visitante_sim">Sim</label>
        <input type="radio" id="houve_visitante_nao" name="houve_visitante" value="0">
        <label for="houve_visitante_nao">Não</label><br>

        <!-- Campo condicional para o número de visitantes -->
        <div id="visitantes" style="display: none;">
            <label for="numero_visitantes">Número de visitantes:</label>
            <input type="number" id="numero_visitantes" name="numero_visitantes"><br>
        </div><br>

        <label>Foi um evento?</label><br>
        <input type="radio" id="foi_evento_sim" name="foi_evento" value="1">
        <label for="foi_evento_sim">Sim</label>
        <input type="radio" id="foi_evento_nao" name="foi_evento" value="0">
        <label for="foi_evento_nao">Não</label><br>

        <!-- Campo condicional para o nome do evento -->
        <div id="evento_nome" style="display: none;">
            <label for="qual_evento">Digite o nome do evento:</label>
            <input type="text" id="qual_evento" name="qual_evento"><br>
        </div><br>

        <label for="criancas_presentes">Número de crianças presentes:</label>
        <input type="number" id="criancas_presentes" name="criancas_presentes"><br><br>

        <label>Coordenador presente?</label><br>
        <input type="radio" id="coordenador_presente_sim" name="coordenador_presente" value="1">
        <label for="coordenador_presente_sim">Sim</label>
        <input type="radio" id="coordenador_presente_nao" name="coordenador_presente" value="0">
        <label for="coordenador_presente_nao">Não</label><br><br>

        <label>Supervisor presente?</label><br>
        <input type="radio" id="supervisor_presente_sim" name="supervisor_presente" value="1">
        <label for="supervisor_presente_sim">Sim</label>
        <input type="radio" id="supervisor_presente_nao" name="supervisor_presente" value="0">
        <label for="supervisor_presente_nao">Não</label><br><br>

        <label for="observacoes">Observações:</label><br>
        <textarea id="observacoes" name="observacoes"></textarea><br><br>

        <h3>Presenças</h3>
        <?php
        // Exibe os membros da célula com checkboxes para marcar presença
        try {
            $stmt = $pdo->prepare("SELECT m.cpf, m.nome_completo FROM membros m WHERE m.numero_celula = :numero_celula");
            $stmt->bindParam(':numero_celula', $numero_celula);
            $stmt->execute();
            $membros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($membros as $membro) {
                echo '<label><input type="checkbox" name="presenca[' . $membro['cpf'] . ']" value="1"> ' . $membro['nome_completo'] . '</label><br>';
            }
        } catch (Exception $e) {
            debug($e->getMessage());
        }
        ?><br>

        <input type="submit" value="Enviar Relatório">
    </form>

    <script>
        // Exibir campos condicionais com base na seleção
        document.getElementById('houve_conversao_sim').addEventListener('change', function() {
            document.getElementById('convertidos').style.display = 'block';
        });
        document.getElementById('houve_conversao_nao').addEventListener('change', function() {
            document.getElementById('convertidos').style.display = 'none';
        });

        document.getElementById('houve_visitante_sim').addEventListener('change', function() {
            document.getElementById('visitantes').style.display = 'block';
        });
        document.getElementById('houve_visitante_nao').addEventListener('change', function() {
            document.getElementById('visitantes').style.display = 'none';
        });

        document.getElementById('foi_evento_sim').addEventListener('change', function() {
            document.getElementById('evento_nome').style.display = 'block';
        });
        document.getElementById('foi_evento_nao').addEventListener('change', function() {
            document.getElementById('evento_nome').style.display = 'none';
        });
    </script>
</body>
</html>
