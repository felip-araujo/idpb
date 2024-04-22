<?php 
    session_start();

    if(!isset($_SESSION['autenticado'])) {
        echo "<script>alert('Usuário não autenticado, faça login!')</script>"; 
        echo '<script>window.location.href="/idpb/login"</script>';
    }

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painél do Líder IDPB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
        }

        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            color: white;
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
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
    </style>
</head>

<body>

    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
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

            <h2> <?php echo $_SESSION['funcao_usuario']; ?></h2>
            <h2>Olá Líder! Bem-vindo à sua Dashboard </h2>
            <p>Aqui você pode gerenciar tudo!</p>
        </div>
    </div>

    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d4755c66d3.js" crossorigin="anonymous"></script>
</body>

</html>