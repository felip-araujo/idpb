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
            <!-- <div class="tab-foto"><img src="" alt=""></div> --> 
            <div class="tab-foto"><img src="<?= $link_foto ?>" alt=""></div>
            <div class="tab-name"> <?= $primeiroNome, " ▸ ", $funcao; ?> </div>
            <div onclick="sairDiv()" class="tab"><a href="/idpb/login">Sair</a> </div>
            <div onclick="" class="tab"><a href="">Configurações</a> </div>
            <div onclick="" class="tab"><a href="upload_foto.php">Alterar foto</a> </div>
        </div>

        <!-- Botão de alternância -->
        <div class="tab-foto-2"><img src="<?= $link_foto ?>" alt=""></div>
        <div class="toggle-btn" id="toggleBtn" onclick="toggleSidebar()">☰</div>  
        

        <!-- Conteúdo -->
        <div class="content" id="content">
            <!-- Aqui vai o conteúdo da dashboard -->
            <div class="ident" id="ident">
                <h1 class="saudacao">Bem-vindo, <?= $primeiroNome?>! </h1>
                <p class="p-saudacao">Vamos começar...</p>
            </div>

            <div class="area1" id="area1">
                <div onclick="irCadastro()" class="content-btn" id="btns">Cadastrar membro de célula </div>
                <div onclick="irRelatorio()" class="content-btn" id="btns">Gerar novo relatório</div>
                <div onclick="verRelatorio()" class="content-btn" id="btns">Visualizar relatório</div>
            </div>

            <div class="area1" id="area1">
                <div class="content-gap" id="lideranca"> lideranca </div>
                <div class="content-gap" id="supervisão"> supervisão </div>
                <div class="content-gap" id="coordenacao"> coordenacao </div>
            </div>

        </div>
    </div>


    <script src="/idpb/dashboard/assets.dashboard/js/main.js"></script>

</body>

</html>