<?php
session_start();
require './php/conexao.php';


if (!isset($_SESSION['id']) || !isset($_SESSION['nome'])) {
    echo "<script>alert('Usuário não autenticado, faça login!')</script>";
    echo '<script>window.location.href="/idpb/login"</script>';
} else { 

     

    $busca_funcao = $pdo->prepare("SELECT Nome_Funcao FROM Funcoes_X WHERE ID_Funcao = :funcao_usuario ");
    $busca_funcao->bindParam(':funcao_usuario', $_SESSION['funcao_usuario']);
    $busca_funcao->execute();
    $return_funcao = $busca_funcao->fetch(PDO::FETCH_ASSOC);
    $nome_funcao = $return_funcao['Nome_Funcao'];
    $_SESSION['nome_funcao'] = $nome_funcao;

    $nome_completo = $_SESSION['nome'];
    $partes_do_nome = explode(' ', $nome_completo);
    $primeiro_nome = $partes_do_nome[0];
    date_default_timezone_set('America/Manaus');
    $hora_atual = date("H");

    if ($hora_atual < 12) {
        $saudacao = "Bom dia";
    } elseif ($hora_atual < 18) {
        $saudacao = "Boa tarde";
    } else {
        $saudacao = "Boa noite";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema IDPB</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="icon" href="/idpb/assets/images/main-logo.png">
    <link rel="stylesheet" href="./assets/css/main.css">
</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="meuModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Cadastrar Membro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    include('../gestao/inserir-usuarios.html');
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3 -->
    <div class="modal fade" id="inserir_funcao_membro" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Inserir Funcão de Membro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php include('../gestao/inserir-nova-funcao-em-usuario.html') ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a class="" style="font-weight: 200; margin-top: 1rem; color: #edb62b;"> <?php echo $_SESSION['nome_funcao']; ?></a>
        <a style="background-color:#222; font-size: 18px; text-decoration:none; margin-bottom: .5rem; margin-top: .8rem;" href="#"> <i class="fa-solid fa-chart-line"></i> Dashboard </a>
        <a id="linkMembros" style="background-color:#222; font-size: 18px; text-decoration:none; margin-bottom: .5rem;" href="#"> <i class="fa-solid fa-user"></i> Membros</a>
        <a id="linkCelulas" style="background-color:#222; font-size: 18px; text-decoration:none; margin-bottom: .5rem;" href="#"> <i class="fa-solid fa-users"></i> </i> Celulas</a>
        <a style="background-color:#222; font-size: 18px; text-decoration:none; margin-bottom: .5rem;" href="#"> <i class="fa-solid fa-chart-bar"></i> Relatórios</a>
        <a style="background-color:#222; font-size: 18px; text-decoration:none; margin-bottom: .5rem;" href="#"> <i class="fa-solid fa-receipt"></i></i> Suporte</a>
        <a style="background-color:#222; font-size: 18px; text-decoration:none; margin-bottom: .5rem;" href="#"> <i class="fa-solid fa-gear"></i> Configurações</a>
    </div>

    <div class="main">
        <nav class="navbar navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" onclick="openNav()">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- <a class="navbar-brand"><i><img src="/idpb/assets/css/image/main-logo.png" class="w-25 d-fluid" alt=""></i> </a> -->
            <a class="navbar-brand" href="../gestao/backend/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
        </nav>

        <div class="container-fluid">

            <h3 style="font-weight: 700; margin-top: .9rem;"><?php echo $saudacao . ', ' . $primeiro_nome . '!'; ?> </h3>
            <p>Aqui você pode gerenciar tudo!</p>

            <div class="container d-fluid text-left " style="padding: 1rem;">

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#meuModal">
                    Cadastrar novo membro na liderança
                </button>
        
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inserir_funcao_membro">
                    Inserir nova Função para Membro da Liderança
                </button>
               
            </div>
            <div id="loadingIcon" style=" display: none; color:#222;" class="text-center">
                <i class="fa fa-spinner fa-spin"></i>
            </div>

            <div class="container" id="conteudoMembros"></div>
            <div class="container" id="conteudoCelulas"></div>
            <div class="container-fluid">
                <div class="row" style="background-color: #999; padding: 1rem;">
                    <div class="col-sm text-light rounded" style="background-color:#222; margin-left:.5rem; margin-right:.5rem;">
                        <?php include_once '../graficos/analise.php' ?>
                    </div>
                    <div class="col-sm text-light rounded" style="background-color:#444; margin-left:.5rem; margin-right:.5rem;">
                        2
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./assets/js/main.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/d4755c66d3.js" crossorigin="anonymous"></script>

</body>

</html>