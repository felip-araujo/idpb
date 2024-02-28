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
    <div class="sidebar" id="sidebar">
        <!-- Aba da Dashboard -->
        <div class="tab-name"> <?= $primeiroNome," ▸ ", $funcao; ?> </div>  
        <div onclick="sairDiv()" class="tab"> <a href="/idpb/login/">Sair</a> </div> 
    </div>

    <!-- Botão de alternância -->
    <div class="toggle-btn" id="toggleBtn" onclick="toggleSidebar()">☰</div> 

    <!-- Conteúdo -->
    <div class="content" id="content">
        <!-- Aqui vai o conteúdo da dashboard -->
        <h1>Bem-vindo, <?= $primeiroNome; ?>! </h1>
        <p>Vamos começar...</p>
    </div>
</div>

    
    <script src="/idpb/dashboard/assets.dashboard/js/main.js"></script>
  
</body>

</html>