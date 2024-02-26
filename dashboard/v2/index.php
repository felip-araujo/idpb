
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/idpb/assets/images/main-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/idpb/dashboard/assets.dashboard/css/global.css">
    <title>Bem-Vindo</title>
</head>

<body >
    <div class="container-top">
        <?php
        session_start();

        if (isset($_SESSION['usuario_email'])) 
        {
            echo "<h2> Seja bem-vindo,  " . $_SESSION['usuario_nome'] . "</h2>";
        } 

        require '/conexao.php';

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

        ?>


    </div>
</body>

</html>