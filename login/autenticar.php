<?php 
    session_start();
    if(isset($_POST['entrar'])) {
        require 'conexao.php';

        $email = $_POST['email'];
        $senha = $_POST['senha'];  

        $busca = $pdo->prepare("SELECT ID_Usuario, Nome, Email, Senha FROM Usuarios_X where Email = :email");
        $busca->bindParam(':email', $email);
        $busca->execute(); 
        $resultado_usuario =  $busca->fetchAll(PDO::FETCH_ASSOC);

        $id_usuario = $resultado_usuario[0]['ID_Usuario'];  
        $nome = $resultado_usuario[0]['Nome'];
        

        if(password_verify($senha, $resultado_usuario[0]['Senha'])){
            
            $autenticado = true;
            $_SESSION['autenticado'] = $autenticado;
        
            $busca_funcao = $pdo->prepare("SELECT * FROM Usuario_Funcoes_X WHERE ID_Usuario = :id_usuario");
            $busca_funcao->bindParam(':id_usuario', $id_usuario); 
            $busca_funcao->execute();
            $resultado_funcao = $busca_funcao->fetchAll(PDO::FETCH_ASSOC);
            $funcao_usuario = $resultado_funcao[0]['ID_Funcao']; 
            

            $_SESSION['funcao_usuario'] = $funcao_usuario;
            $_SESSION['id'] = $id_usuario; 
            $_SESSION['nome'] = $resultado_usuario[0]['Nome'];

          
            switch ($funcao_usuario) {
                case 1:
                    // echo "dashboard do líder {com switch}"; 
                    echo '<script>window.location.href="../dashboard/v2/dashboard.php"</script>'; 
                    break; 
                case 2: 
                    echo "dashboard do supervisor {com switch}";
                    echo '<script>window.location.href="../dashboard/v2/dashboard.php"</script>'; 
                    break; 
                case 3: 
                    echo "dashboard do coordenador {com switch}";
                    
                    break;
                case 4:   
                    echo "dashboard do coordenador {com switch}"; 
                    echo '<script>window.location.href="../dashboard/v2/dashboard.php"</script>'; 
                    $_SESSION['autenticado'] = true;
                    break;
                case null:
                    echo "<script>alert('O usuário não possui função ministerial!')</script>";
                    echo '<script>window.location.href="/idpb/login"</script>';
            }
            
        } else {
            echo "<script>alert('Combinação de Email/Senha Incorretos')</script>";
            echo '<script>window.location.href="../login"</script>';
        }
    } 


?>