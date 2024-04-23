<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['autenticado'])) {
    echo "<script>alert('Usuário não autenticado, faça login!')</script>";
    echo '<script>window.location.href="/idpb/login"</script>';
}

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



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painél do Líder IDPB</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


    <link rel="icon" href="../assets/css/image/main-logo.png">
    <style>
        body {
            min-height: 100vh;
            overflow-x: hidden;
            font-family: 'Raleway', sans-serif;
            /* Evitar scroll horizontal */
        }

        /* Estilos da sidebar */
        .sidebar {
            height: 100%;
            width: 0%;
            /* Sidebar inicialmente oculta */
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: width 0.5s;
            /* Animar a largura */
            padding-top: 2rem;
            /* Altura da navbar */
            color: white;
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: color 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }

        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        /* Estilos do conteúdo principal */
        .main {
            transition: margin-left 0.5s;
            /* Animar a margem esquerda */
            padding: 0;
            margin-left: 0rem;
            /* Inicialmente sem margem */
        }

        /* Estilos da navbar para mantê-la no topo */
        .navbar {
            margin-bottom: 0;
            background-image: linear-gradient(to left, rgb(5, 64, 92), .1%, #000000);
            /* Remover margem */
        }
    </style>
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
                    <?php include '../gestao/inserir-usuarios.php' ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 -->
    <div class="modal fade" id="alterar_funcao_membro" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Cadastrar Membro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php include '../gestao/alterar-funcao.php' ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a class="" style="font-size: ; margin-top: 1rem; color: #edb62b;"> <?php echo $_SESSION['nome_funcao']; ?></a>
        <a href="#">Dashboard</a>
        <a href="#">Relatórios</a>
        <!-- <a href="#">Análises</a> -->
        <a href="#">Configurações</a>
    </div>

    <div class="main">
        <nav class="navbar navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" onclick="openNav()">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- <a class="navbar-brand"><i><img src="/idpb/assets/css/image/main-logo.png" class="w-25 d-fluid" alt=""></i> </a> -->
            <a class="navbar-brand" href="/idpb/login"><i class="fa-solid fa-right-from-bracket"></i></a>
        </nav>

        <div class="container-fluid">


            <div> 
                <?php if (isset($_SESSION['mensagem'])) {
                        echo $_SESSION['mensagem'];
                        // Limpe a mensagem depois de exibi-la para não aparecer novamente após o refresh
                        unset($_SESSION['mensagem']);
                    } ?> 
                </div>

            <h3 style="font-weight: 700; margin-top: .9rem;"><?php echo $saudacao . ', ' . $primeiro_nome . '!'; ?> </h3>
            <p>Aqui você pode gerenciar tudo!</p>

            <div class="container d-fluid text-left " style="padding: 1rem;">

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#meuModal">
                    Cadastrar novo membro
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#alterar_funcao_membro">
                    Alterar Função de Membro
                </button>
                <a href=""><button class="btn btn-outline-dark">Criar ou Alterar Funções</button></a>
            </div>

        </div>
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




    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.querySelector(".main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.querySelector(".main").style.marginLeft = "0";
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d4755c66d3.js" crossorigin="anonymous"></script>

</body>

</html>