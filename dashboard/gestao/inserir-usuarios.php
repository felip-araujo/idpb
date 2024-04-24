<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Inclusão do CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    

    <title>Inserir Usuários</title>
</head>

<style>
    body{
        background-color: #818181;
    }
</style>

<body> 

    <div class="container"> 

        <div> <?php if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    // Limpe a mensagem depois de exibi-la para não aparecer novamente após o refresh
                    unset($_SESSION['mensagem']);
                    ob_end_flush();
                } ?> </div>

        <form action="" method="POST">
            <label for="email" class="form-label ">Email</label>
            <input type="email" class="form-control" name="email" id="email">

            <label for="" class="form-label ">Senha</label>
            <div class="input-group">
                <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha">
                <span class="input-group-text">
                    <i class="fa fa-eye" id="togglePassword"></i>
                </span>
            </div>


            <label for="" class="form-label ">Nome Completo:</label>
            <input type="text" class="form-control" name="nome" id="nome">

            <label for="num_celula" class="form-label ">Número Célula</label>
            <select name="num_celula" id="num_celula" class="form-control">
                <?php foreach ($celulas as $celula) {
                    echo "<option value='{$celula['Numero_Celula']}'>{$celula['Numero_Celula']}</option>";
                } ?>

            </select>

            <label for="" class="form-label ">Número Supervisão</label>
            <select name="num_supervisao" id="num_s" class="form-control">
                <?php foreach ($supervisoes as $supervisao) {
                    echo "<option value='{$supervisao['Numero_Supervisao']}'>{$supervisao['Numero_Supervisao']}</option>";
                } ?>
            </select>

            <label for="" class="form-label ">Número Coordenação</label>
            <select name="num_coord" id="num_coord" class="form-control">
                <?php foreach ($coordenacoes as $coordenacao) {
                    echo "<option value='{$coordenacao['Numero_Coordenacao']}'>{$coordenacao['Numero_Coordenacao']}</option>";
                }
                ?>
            </select>

            <label for="" class="form-label ">Função do Usuário</label>
            <select name="funcao_usuario" id="funcao_usuario" class="form-control">
                <?php foreach ($funcoes as $funcao) {
                    echo "<option value='{$funcao['Nome_Funcao']}'>{$funcao['Nome_Funcao']}</option>";
                }
                ?>
            </select>

            <br><input type="submit" name="enviar" class="btn btn-primary">
        </form>
    </div>

</body> 

<script>
document.getElementById('togglePassword').addEventListener('click', function (e) {
    // Alternar entre visualizar e ocultar a senha
    const password = document.getElementById('senha');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    
    // Alternar o ícone
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});
</script> 
<script src="./ajax.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://kit.fontawesome.com/d4755c66d3.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-- Inclusão do JavaScript do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>


</html>