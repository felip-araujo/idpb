<?php
include './conexao.php';
$email = $_POST['email'] ?? null;
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT) ?? null; // Criptografando a senha
$nome = $_POST['nome'] ?? null;
$num_celula = $_POST['num_celula'] ?? null;
$num_supervisao = $_POST['num_supervisao'] ?? null;
$num_coordenacao = $_POST['num_coordenacao'] ?? null;
$funcao_usuario = $_POST['selecionar_Funcao'] ?? null;

if ($email && $senha && $nome && $$num_celula && $num_supervisao && $num_coordenacao && $funcao_usuario) {
    try {

        $qremail = $pdo->prepare("SELECT Email FROM Usuarios_X where Email = :email");
        $qremail->bindParam(':email', $email);
        $qremail->execute();
        $retorno = $qremail->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($retorno)) {
            echo '<p class="alert alert-danger" > Este usuário já foi cadastrado! </p>';
        } else {
            $stmt = $pdo->prepare("INSERT INTO Usuarios_X (Email, Senha, Nome, Numero_Celula, Numero_Supervisao, Numero_Coordenacao) 
                                   VALUES (:email, :senha, :nome, :num_celula, :num_supervisao, :num_coordenacao)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':num_celula', $num_celula);
            $stmt->bindParam(':num_supervisao', $num_supervisao);
            $stmt->bindParam(':num_coordenacao', $num_coordenacao);
            $stmt->execute();

            if ($stmt->rowCount() >= 1) {
                $ultimoID = $pdo->lastInsertId();
                $inserir_funcao = $pdo->prepare("INSERT INTO Usuario_Funcoes_X (ID_Usuario, ID_Funcao) VALUES (:ultimoID, :id_funcao)");
                $inserir_funcao->bindParam(':ultimoID', $ultimoID);
                $inserir_funcao->bindParam(':id_funcao', $funcao_usuario);
                $inserir_funcao->execute();

                if ($inserir_funcao->rowCount() >= 1) {
                    echo '<p class="alert alert-success" > Usuário cadastrado com sucesso! </p>';
                } else {
                    echo '<p class="alert alert-danger" > Erro ao cadastrar a função do usuário no Banco de Dados, contate o Administrador. </p>';
                }
            }
        }
    } catch (PDOException $e) {
    };
};
