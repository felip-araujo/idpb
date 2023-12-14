<link rel="stylesheet" href="assets/css/formulario.css">  

<link rel="stylesheet" href="assets/css/formulario.css">
<form action="" method="POST" class="formulario">
    
    <h2 id="titulo" class="titulo">Endereço</h2>
    
    <label for="rua" class="label">Rua:</label> 
    <input type="text" id="rua" name="rua" class="input" placeholder="Avenida..."> 
    
    <label for="numero" class="label">Nº Casa:</label> 
    <input type="text" id="numero" name="numero" class="input" placeholder="Nº 01"> 
    
    <label for="complemento" class="label">Complemento</label> 
    <input type="text" id="complemento" name="complemento" class="input" placeholder="complemento"> 
    
    <label for="bairro" class="label">Bairro:</label> 
    <input type="text" id="bairro" name="bairro" class="input"> 
    
    <label for="genero" class="label">Estado:</label> 
    <select name="estado" id="estado" class="input-select">
    <option value="AC">AC</option>
        <option value="AL">AL</option>
        <option value="AP">AP</option>
        <option value="AM">AM</option>
        <option value="BA">BA</option>
        <option value="CE">CE</option>
        <option value="DF">DF</option>
        <option value="ES">ES</option>
        <option value="GO">GO</option>
        <option value="MA">MA</option>
        <option value="MT">MT</option>
        <option value="MS">MS</option>
        <option value="MG">MG</option>
        <option value="PA">PA</option>
        <option value="PB">PB</option>
        <option value="PR">PR</option>
        <option value="PE">PE</option>
        <option value="PI">PI</option>
        <option value="RJ">RJ</option>
        <option value="RN">RN</option>
        <option value="RS">RS</option>
        <option value="RO">RO</option>
        <option value="RR">RR</option>
        <option value="SC">SC</option>
        <option value="SP">SP</option>
        <option value="SE">SE</option>
        <option value="TO">TO</option>    
    </select> 

    <button class="btn" type="suubmit" name="cadastrar-endereco" value="cadastrar-endereco">Cadastrar</button>


</form>