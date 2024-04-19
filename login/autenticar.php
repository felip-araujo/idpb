<?php 
    session_start();
    if(isset($_POST['entrar'])) {
        require 'conexao.php';

        $email = $_POST['email'];
        $senha = $_POST['senha'];  

        $busca = $pdo->prepare("SELECT id_usuario, nome, email, senha FROM usuarios where email = :email");
        $busca->bindParam(':email', $email);
        $busca->execute(); 
        $resultado_usuario =  $busca->fetchAll(PDO::FETCH_ASSOC);

        $id_usuario = $resultado_usuario[0]['id_usuario'];  
        $nome = $resultado_usuario[0]['nome'];
        // var_dump($id_usuario);

        if(password_verify($senha, $resultado_usuario[0]['senha'])){
            
            $autenticado = true;
            $_SESSION['autenticado'] = $autenticado;
        
            $busca_funcao = $pdo->prepare("SELECT * FROM usuarios_funcoes WHERE id_usuario = :id_usuario");
            $busca_funcao->bindParam(':id_usuario', $id_usuario);
            $busca_funcao->execute();
            $resultado_funcao = $busca_funcao->fetchAll(PDO::FETCH_ASSOC);
            $funcao_usuario = $resultado_funcao[0]['id_funcao']; 
            $_SESSION['funcao_usuario'] = $funcao_usuario;

          
            switch ($funcao_usuario) {
                case 1:
                    echo "dashboard do líder {com switch}"; 
                    break; 
                case 2: 
                    echo "dashboard do supervisor {com switch}";
                    break; 
                case 3: 
                    echo "dashboard do coordenador {com switch}";
                    break;
                case 4:  
                    echo "dashboard do coordenador {com switch}"; 
                    echo '<script>window.location.href="../dashboard/v2/pastor-dashboard.php"</script>'; 
                    $_SESSION['autenticado'] = true;
                    break;
            }
            
        } else {
            echo "<script>alert('Combinação de Email/Senha Incorretos')</script>";
            echo '<script>window.location.href="../login"</script>';
        }
    } 


?>