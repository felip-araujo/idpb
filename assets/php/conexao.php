<?php 

    $host = '108.167.151.34'; 
    $user = 'evolud85_felp'; 
    $password = 'ft71m8^{OjKW'; 
    $dbname = 'evolud85_idpb'; 

    $con = mysqli_connect($host, $user, $password, $dbname); 

    if(!$con){
        echo("Erro ao conectar ao Banco de Dados"); 
    } else {
        echo("Conectado com Sucesso!");
    }
?>  