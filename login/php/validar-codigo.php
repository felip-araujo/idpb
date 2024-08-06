<?php
session_start();
require '../php/conexao.php';
date_default_timezone_set('America/Sao_Paulo');

if (isset($_POST['enviar'])) {
    try {
        // Obtém o código enviado e a data e hora atual
        $codigo_enviado = $_POST['codigo'];
        $dataHoraAtual = date('Y-m-d H:i:s'); // Obter a data e hora atual

        // Prepara e executa a consulta
        $busca = $pdo->prepare("SELECT * FROM Troca_Senha_Usuarios WHERE codigo = :codigo");
        $busca->bindParam(':codigo', $codigo_enviado);
        $busca->execute();
        $resultado = $busca->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $codigo_db = $resultado['codigo'];
            $data_expiracao = $resultado['data_expiracao'];



            if ($codigo_enviado == $codigo_db and $dataHoraAtual < $data_expiracao) {
                header("Location: ./troca-senha.php?codigo=" . urlencode($codigo_enviado));
                exit;
            } else {
                echo "<script type='text/javascript'>
                    alert('Código inválido ou expirado!');
                    window.location.href = '../index.html';
                </script>";
                exit;
            }
        } else {
            echo "<script type='text/javascript'>
                alert('Código Inválido!');
                window.location.href = '../index.html';
            </script>";
            exit;
        }
    } catch (PDOException $e) {
        // Trata erros de conexão e execução
        echo "Erro ao acessar o banco de dados: " . $e->getMessage();
    } catch (Exception $e) {
        // Trata outros erros
        echo "Erro: " . $e->getMessage();
    }
}
