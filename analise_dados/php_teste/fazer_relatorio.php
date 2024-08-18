<?php
session_start();

// Incluir o arquivo de conexão
include 'conexao.php';

// Buscar os membros da célula
$numero_celula = $_SESSION['numero_celula']; // Obtendo o número da célula da sessão
$sql = "SELECT cpf, nome FROM membros WHERE numero_celula = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $numero_celula, PDO::PARAM_INT);
$stmt->execute();
$membros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Armazenar os membros na sessão
$_SESSION['membros'] = $membros;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Presença</title>
    <script>
        function toggleElement(checkbox, elementId) {
            var element = document.getElementById(elementId);
            if (checkbox.checked) {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        }

        function addNewConvert() {
            var container = document.getElementById("newConvertsContainer");
            var div = document.createElement("div");

            var emailInput = document.createElement("input");
            emailInput.type = "email";
            emailInput.name = "convertidos_email[]";
            emailInput.placeholder = "Email do convertido";
            emailInput.required = true;

            var phoneInput = document.createElement("input");
            phoneInput.type = "tel";
            phoneInput.name = "convertidos_telefone[]";
            phoneInput.placeholder = "Telefone do convertido";
            phoneInput.required = true;

            div.appendChild(emailInput);
            div.appendChild(phoneInput);
            container.appendChild(div);
        }
    </script>
</head>
<body>
    <form method="POST" action="">

        <!-- Selecione a Data -->
        <label>Selecione a data:</label>
        <input type="date" name="data" required><br><br>

        <!-- Conversão -->
        <label>Houve alguma conversão?</label>
        <input type="checkbox" name="houve_conversao" id="houve_conversao" onclick="toggleElement(this, 'conversionDetails')"><br>

        <div id="conversionDetails" style="display:none;">
            <label>Email ou telefone do(s) novo(s) convertido(s):</label><br>
            <div id="newConvertsContainer">
                <input type="email" name="convertidos_email[]" placeholder="Email do convertido">
                <input type="tel" name="convertidos_telefone[]" placeholder="Telefone do convertido"><br>
            </div>
            <button type="button" onclick="addNewConvert()">Adicionar mais um convertido</button><br><br>
        </div>

        <!-- Evento -->
        <label>Foi um evento?</label>
        <input type="checkbox" name="foi_evento" id="foi_evento" onclick="toggleElement(this, 'eventDetails')"><br>

        <div id="eventDetails" style="display:none;">
            <label>Qual evento:</label>
            <input type="text" name="qual_evento"><br><br>
        </div>

        <!-- Lista de Presença -->
        <label>Lista de Presença:</label><br>
        <?php
        foreach ($_SESSION['membros'] as $membro) {
            echo '<label>' . htmlspecialchars($membro['nome']) . '</label>';
            echo '<input type="checkbox" name="presenca[' . htmlspecialchars($membro['cpf']) . ']" value="sim">';
            echo '<br>';
        }
        ?><br>

        <!-- Quantidade de Crianças -->
        <label>Quantidade de crianças:</label>
        <input type="number" name="criancas_presentes" min="0" required><br><br>

        <!-- Coordenador presente -->
        <label>Coordenador estava presente?</label>
        <input type="checkbox" name="coordenador_presente"><br><br>

        <!-- Supervisor presente -->
        <label>Supervisor estava presente?</label>
        <input type="checkbox" name="supervisor_presente"><br><br>

        <button type="submit">Salvar Presença</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST['data'];
        $houve_conversao = isset($_POST['houve_conversao']) ? 'sim' : 'não';
        $foi_evento = isset($_POST['foi_evento']) ? 'sim' : 'não';
        $qual_evento = $_POST['qual_evento'] ?? null;
        $criancas_presentes = $_POST['criancas_presentes'];
        $coordenador_presente = isset($_POST['coordenador_presente']) ? 'sim' : 'não';
        $supervisor_presente = isset($_POST['supervisor_presente']) ? 'sim' : 'não';
        $presencas = $_POST['presenca'];

        // Inserir presenças na tabela
        foreach ($presencas as $cpf => $presente) {
            $sql = "INSERT INTO presencas (numero_celula, cpf, data, presente, houve_conversao, foi_evento, qual_evento, criancas_presentes, coordenador_presente, supervisor_presente) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$numero_celula, $cpf, $data, $presente, $houve_conversao, $foi_evento, $qual_evento, $criancas_presentes, $coordenador_presente, $supervisor_presente]);
        }

        // Inserir convertidos na tabela de convertidos
        if ($houve_conversao === 'sim') {
            $emails = $_POST['convertidos_email'];
            $telefones = $_POST['convertidos_telefone'];

            foreach ($emails as $index => $email) {
                $telefone = $telefones[$index];
                $sql = "INSERT INTO convertidos (numero_celula, data, email, telefone) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$numero_celula, $data, $email, $telefone]);
            }
        }

        echo "Presenças e informações salvas com sucesso!";
    }

    $pdo = null; // Fechar a conexão
    ?>
</body>
</html>
