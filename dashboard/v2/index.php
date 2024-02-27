<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/idpb/dashboard/assets.dashboard/css/global.css">
    <link rel="shortcut icon" href="/idpb/assets/css/image/main-logo.png" type="image/x-icon">
    <title>Painel da Liderança</title>
</head>

<body>
    <?php include_once 'verficacoes.php'; ?>

    <div class="wrapper">
        
        <div class="sidebar">
            <!-- Aba da Dashboard -->
            <div class="tab-name"> <?= $primeiroNome; ?> </div>  
            <div class="tab-info"> <?= $numero_celula, " | ", $funcao; ?> </div>  
            <div class="tab"> <a href="/idpb/login/">Sair</a> </div> 
            
        </div>

        <!-- Conteúdo -->
        <div class="content">
            <!-- Aqui vai o conteúdo da dashboard -->
            <h1>Bem-vindo, <?= $primeiroNome; ?>! </h1>
            <p>Vamos começar...</p>
        </div>
    </div>
</body>

</html>