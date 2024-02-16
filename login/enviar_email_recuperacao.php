<?php
// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber o email fornecido pelo usuário
    $email = $_POST['email'];
    
    
    // Função para enviar e-mail de recuperação de senha
    function enviarEmailRecuperacaoSenha($email, $token) {
        $assunto = 'Recuperação de Senha';
        $mensagem = 'Para redefinir sua senha, clique no seguinte link: 
                     http://seusite.com/redefinir_senha.php?token=' . $token;
        $headers = 'From: seuemail@seusite.com' . "\r\n" .
                   'Reply-To: seuemail@seusite.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
    
        return mail($email, $assunto, $mensagem, $headers);
    } 

    
// Função para gerar um token único
function gerarTokenUnico() {
    return md5(uniqid(mt_rand(), true));
}

// Gerar um token único
$token = gerarTokenUnico();

echo $token; // Exemplo de como você pode usar o token

    
    // Supondo que você já tenha gerado um token único para o usuário
    $token = gerarTokenUnico();
    
    // Enviar o e-mail de recuperação de senha
    $email = 'emaildoUsuario@example.com'; // Substitua pelo e-mail do usuário
    if (enviarEmailRecuperacaoSenha($email, $token)) {
        echo 'E-mail de recuperação de senha enviado com sucesso.';
    } else {
        echo 'Erro ao enviar o e-mail de recuperação de senha.';
    }

    
}
?>
