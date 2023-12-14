<?php 

    session_start(); // iniciar a sessão

    //verifica se está criada a sessão para controlar as etapas 
    if(!isset($_SESSION['etapa'])){
        //cria a sessão para armazenar a etapa
        $_SESSION['etapa'] = 1;
    } 
    
     $_SESSION['etapa'] = 1;
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/cadastro.css">
    <title>Fazer Login</title>
</head>

<body>                      
    <?php 
        //receber dados 
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        

        // SALVA OS DADOS DO USUÁRIO // 
        include_once './cadastrar_usuario.php';


        //VERIFICAR SE DEVE CARREGAR O FORMULARIO DA ETAPA 1 
        if($_SESSION['etapa'] == 1){
           include_once './formulario_cadastrar_usuario.php';

        } else if ($_SESSION['etapa'] == 2){
            include_once './formulario_dadospessoais.php';

        } else if ($_SESSION['etapa'] == 3){
            include_once './formulario_endereco.php';

        } else if ($_SESSION['etapa'] == 4){
            include_once './formulario_celula.php';

        }
    ?>

    <script src="/assets/js/cadastro.js"></script>
</body>

</html>