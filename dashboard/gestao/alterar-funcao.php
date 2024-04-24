<?php

include '../gestao/backend/conexao.php';
$mensagem = '';
try {
    // Consultas para buscar os dados
    $usuarios = $pdo->query("SELECT Nome FROM Usuarios_X")->fetchAll(PDO::FETCH_ASSOC);
    $funcoes = $pdo->query("SELECT ID_Funcao, Nome_Funcao FROM Funcoes_X")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(['error' => "Erro na base de dados: " . $e->getMessage()]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Alterar Funcao</title>
</head>

<body>
    <div class="container" style="margin-top: .8rem;">
        <div> <?php if ($mensagem) {
                    echo $mensagem;
                    // Limpe a mensagem depois de exibi-la para não aparecer novamente após o refresh
                    // unset($_SESSION['mensagem']);
                } ?> </div>

        <form action="../gestao/backend/processar_alterar_funcao.php" method="POST" id="alterar_funcao">
            <label for="usuario" class="form-label">Usuario:</label>
            <select name="usuario" id="usuario" class="form-control">
                <?php foreach ($usuarios as $usuario) {
                    echo "<option value='{$usuario['Nome']}'>{$usuario['Nome']}</option>";
                }

                ?>
            </select>
            <label for="nova_funcao" class="form-label">Nova Função:</label>
            <select name="nova_funcao" id="nova_funcao" class="form-control">
                <?php foreach ($funcoes as $funcao) {
                    echo "<option value='{$funcao['Nome_Funcao']}'>{$funcao['Nome_Funcao']}</option>";
                }
                ?>
            </select>
            <br><button class="btn btn-primary" name="enviar" id="enviar">Enviar</button>
        </form>
    </div>



</body>

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script> 
<script src="../gestao/js/ajax.js"></script>

</html>