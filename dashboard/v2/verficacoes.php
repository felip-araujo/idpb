<?php

require_once '../conexao.php';


session_start();
if (isset($_SESSION['usuario_email'])) {

    $nome = $_SESSION['usuario_nome'];
    $primeiroNome = explode(' ', $nome)[0];
};



// //Busca e verificação na tabela usuarios_funcoes 
//     //-> 1 busca do id na tabela de usuarios
//         $qr01 = "SELECT id_usuario FROM usuarios where nome =:nome "; 
//         $stqr1 = $pdo->prepare($qr01); 
//         $stqr1->bindParam(':nome', $nome); 
//         $stqr1->execute(); 
//         $id_sis = $stqr1->fetch(PDO::FETCH_ASSOC); 
//         $id_sistema = implode(',', $id_sis);

//     // -> 2 verifica qual a função do id na tabela usuarios_funcoes  
//         $qrfunc = "SELECT id_funcao from usuarios_funcoes where id_usuario =:id"; 
//         $stfunc = $pdo->prepare($qrfunc); 
//         $stfunc->bindParam(':id', $id_sistema); 
//         $stfunc->execute(); 
//         $result_func = $stfunc->fetch(PDO::FETCH_ASSOC);
//         var_dump($result_func);
    

//Buscar o Id da tabela Users2
$email = $_SESSION['usuario_email'];
$query_id = " SELECT id FROM users2 WHERE Email=:email";
$stmt_id = $pdo->prepare($query_id);
$stmt_id->bindParam(':email', $email);
$stmt_id->execute();
$id = $stmt_id->fetch(PDO::FETCH_ASSOC);
$id_string = implode(',', $id);


//Buscar foto de perfil do usuario no banco de Dados 
$sqlfoto = "SELECT foto FROM users2 WHERE id = :id ";
$stmtfoto = $pdo->prepare($sqlfoto);
$stmtfoto->bindParam(':id', $id_string);
if ($stmtfoto->execute()) {
    $resultado_foto = $stmtfoto->fetch(PDO::FETCH_ASSOC);
    if ($resultado_foto) {
        $link_foto = $resultado_foto['foto'];

        if ($link_foto == null) {
            $link_foto = '\idpb\upload\set\profile_set.jpg';
        } else {

            $link_foto = explode("C:\wamp64\www", $link_foto);
            $link_foto = $link_foto[1];
        }
    } else {
    }
}


// Buscar dados da tabela funções 
$email = $_SESSION['usuario_email'];
$query_celula = "SELECT nome FROM old_funcoes WHERE Email=:email";
$stmt_celula = $pdo->prepare($query_celula);
$stmt_celula->bindParam(':email', $email);
$stmt_celula->execute();
$resultado_celula = $stmt_celula->fetch(PDO::FETCH_ASSOC);




