<?php

include("conexao.php");

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obter dados do formulário
    $cpf = $_POST["cpf"];
    $nome_completo = $_POST["nome_completo"];
    $data_nascimento = $_POST["data_nascimento"];
    $genero = $_POST["genero"];
    $numero_celular = $_POST["numero_celular"];
    $email = $_POST["email"];
    $estado_civil = $_POST["estado_civil"];
    $numero_celula = $_POST["numero_celula"];
    $participacao_ministerio = $_POST["participacao_ministerio"];
    $data_batismo = $_POST["data_batismo"];
    $data_conversao = $_POST["data_conversao"];
    $escolaridade = $_POST["escolaridade"];
    $profissao = $_POST["profissao"];

    // Campos de endereço
    $cep = $_POST["cep"];
    $rua = $_POST["rua"];
    $bairro = $_POST["bairro"];
    $cidade = $_POST["cidade"];
    $uf = $_POST["uf"];
    $numero = $_POST["numero"];

    // checkbox para receber notícias
    $receber_noticias = $_POST["receber_noticias"];

    try {
        // Verificar se o CPF já está cadastrado
        $verifica_cpf = $pdo->prepare("SELECT cpf FROM membros WHERE cpf = :cpf");
        $verifica_cpf->bindParam(':cpf', $cpf);
        $verifica_cpf->execute();

        if ($verifica_cpf->rowCount() > 0) {
            // Se o CPF já estiver cadastrado, exibir mensagem de erro
            echo"<script>alert('Erro: CPF já cadastrado!')</script>";
        } else {
            // Inserir ou atualizar dados no banco de dados
            $insere_membro = $pdo->prepare("INSERT INTO membros (
                cpf, 
                nome_completo, 
                data_nascimento, 
                genero, 
                numero_celular, 
                email, 
                estado_civil, 
                numero_celula, 
                participacao_ministerio, 
                data_batismo, 
                data_conversao, 
                escolaridade, 
                profissao, 
                cep, 
                rua, 
                bairro, 
                cidade, 
                uf, 
                numero,
                receber_noticias
                ) VALUES (
                    :cpf, 
                    :nome_completo, 
                    :data_nascimento, 
                    :genero, 
                    :numero_celular, 
                    :email, 
                    :estado_civil, 
                    :numero_celula, 
                    :participacao_ministerio, 
                    :data_batismo, 
                    :data_conversao, 
                    :escolaridade, 
                    :profissao, 
                    :cep, 
                    :rua, 
                    :bairro, 
                    :cidade, 
                    :uf, 
                    :numero,
                    :receber_noticias
                    ) ON DUPLICATE KEY UPDATE 
                        nome_completo = :nome_completo, 
                        data_nascimento = :data_nascimento, 
                        genero = :genero, 
                        numero_celular = :numero_celular, 
                        email = :email, 
                        estado_civil = :estado_civil, 
                        numero_celula = :numero_celula, 
                        participacao_ministerio = :participacao_ministerio, 
                        data_batismo = :data_batismo, 
                        data_conversao = :data_conversao, 
                        escolaridade = :escolaridade, 
                        profissao = :profissao, 
                        cep = :cep, 
                        rua = :rua, 
                        bairro = :bairro, 
                        cidade = :cidade, 
                        uf = :uf, 
                        numero = :numero,
                        receber_noticias = :receber_noticias"
                    );

            // Bind dos parâmetros
            $insere_membro->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $insere_membro->bindParam(':nome_completo', $nome_completo);
            $insere_membro->bindParam(':data_nascimento', $data_nascimento);
            $insere_membro->bindParam(':genero', $genero);
            $insere_membro->bindParam(':numero_celular', $numero_celular);
            $insere_membro->bindParam(':email', $email);
            $insere_membro->bindParam(':estado_civil', $estado_civil);
            $insere_membro->bindParam(':numero_celula', $numero_celula);
            $insere_membro->bindParam(':participacao_ministerio', $participacao_ministerio);
            $insere_membro->bindParam(':data_batismo', $data_batismo);
            $insere_membro->bindParam(':data_conversao', $data_conversao);
            $insere_membro->bindParam(':escolaridade', $escolaridade);
            $insere_membro->bindParam(':profissao', $profissao);
            $insere_membro->bindParam(':cep', $cep);
            $insere_membro->bindParam(':rua', $rua);
            $insere_membro->bindParam(':bairro', $bairro);
            $insere_membro->bindParam(':cidade', $cidade);
            $insere_membro->bindParam(':uf', $uf);
            $insere_membro->bindParam(':numero', $numero);
            $insere_membro->bindParam(':receber_noticias', $receber_noticias);

            if ($insere_membro->execute()) {
                // Se o cadastro for bem-sucedido, redireciona para a página principal
                echo"<script>alert('Membro Cadastrado!')</script>";
                header("Location: https://www.idpbfiladelfia.com.br/");
                exit();
            } else {
                // Se ocorrer um erro durante a execução da consulta, exibir mensagem de erro
                echo "Erro ao cadastrar: " . $insere_membro->errorInfo()[2];
            }
        }
    } catch (PDOException $e) {
        // Se ocorrer um erro no banco de dados, exibir mensagem de erro
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}

?>
