
<link rel="stylesheet" href="assets/css/formulario.css">
<form action="" method="POST" class="formulario">
    
    <h2 id="titulo" class="titulo">Dados Pessoais</h2>
    
    <label for="nome" class="label">Primeiro Nome:</label> 
    <input type="text" id="nome" name="primeiro_nome" class="input"> 
    
    <label for="sobrenome" class="label">Sobrenome:</label> 
    <input type="text" id="sobrenome" name="sobrenome" class="input"> 
    
    <label for="cpf" class="label">Cpf:</label> 
    <input type="number" id="cpf" name="cpf" class="input" placeholder="000.000.000-00"> 
    
    <label for="telefone" class="label">Telefone:</label> 
    <input type="number" id="telefone" name="telefone" class="input" placeholder="(00)0000-0000"> 
    
    <label for="genero" class="label">Gênero:</label> 
    <select name="genero" id="genero" class="input-select">
        <option value="masculino">Masculino</option>
        <option value="feminino">Feminino</option> 
    </select> 
    
    <label for="estado_civil" class="label">Estado Civil:</label> 
    <select name="estado_civil" id="estado_civil" class="input-select" >
        <option value="Solteiro(a)">Solteiro(a)</option>
        <option value="Casado(a)">Casado(a)</option>
        <option value="Viúvo(a)">Víuvo(a)</option>
        <option value="Divorciado(a)">Divorciado(a)</option>
    </select> 

    <label for="funcao_na_igreja" class="label">Qual a sua função na igreja?:</label> 
    <select name="funcao_na_igreja" id="funcao_na_igreja" class="input-select" >
        <option value="Pastor">Pastor(a)</option>
        <option value="Coordenador(a)">Coordenador(a)</option>
        <option value="Supervisor(a)">Supervisor(a)</option>
        <option value="Lider">Líder</option>
        <option value="Membro">Membro</option>
    </select> 

    <button class="btn" type="suubmit" name="cadastrar-dados-pessoais" value="cadastrar-dados-pessoais">Cadastrar</button>


</form>