<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Membros</title> 
    <link rel="shortcut icon" type="imagex/png" href="/assets/css/image/main-logo.png">
    
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/style.css">




    <!-- Adicionando Javascript -->
    <script>

        function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
            document.getElementById('uf').value = ("");
            document.getElementById('ibge').value = ("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('rua').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);
            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {

            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('rua').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('uf').value = "...";

                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);

                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        };


    </script>

</head>

<body>
    <div class="container">
        <h2 class="titulo">Cadastro de Membros</h2>
        <h3 class="subtitulo">Nossa missão é amar.</h3> 
        
    </div>
    <div class="container-1">
    <form id="cadastroForm" action="processar_cadastro.php" method="post" class="formulario">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required class="input">

        <label for="nome_completo">Nome Completo:</label>
        <input type="text" id="nome_completo" name="nome_completo" required class="input" placeholder="Ex.:João da Silva">

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required class="input">

        <label for="genero">Gênero:</label>
        <select id="genero" name="genero" required class="input-select">
            <option value="Masculino">Masculino</option>
            <option value="Feminino">Feminino</option>
        </select>
        <label for="numero_celular">Número de Celular ou Telefone:</label>
        <input type="text" id="numero_celular" name="numero_celular" required class="input" placeholder="(00) 00000-0000">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required class="input" placeholder="Ex.:seuemail@email.com">

        <label for="estado_civil">Estado Civil:</label>
        <select id="estado_civil" name="estado_civil" required class="input">
            <option value="Solteiro(a)">Solteiro(a)</option>
            <option value="Casado(a)">Casado(a)</option>
            <option value="Viúvo(a)">Viúvo(a)</option>
            <option value="Divorciado(a)">Divorciado(a)</option>
            <option value="União estável">União estável</option>
        </select>

        <label for="numero_celula">Número da Célula:</label>
        <input class="input" type="text" id="numero_celula" name="numero_celula" required class="input"/>
    
        <button type="button" onclick="buscarDados()" class="input">Buscar Dados</button>
    
        <label for="base">Base:</label>
        <input class="input" type= "text" id="base" disabled />
    
        <label for="coordenacao">Coordenação:</label>
        <input class="input" type="text" id="coordenacao" disabled />
    
        <label for="supervisao">Supervisão:</label>
        <input class="input" type="text" id="supervisao" disabled />
    
        <label for="supervisor">Supervisor:</label>
        <input class="input" type="text" id="supervisor" disabled />
    
        <label for="celula">Célula:</label>
        <input class="input" type="text" id="celula" disabled />
    
        <label for="lideres">Líderes:</label>
        <input class="input" type="text" id="lideres" disabled />

        <label for="participacao_ministerio">Participa ativamente de algum ministério?</label>
        <select id="participacao_ministerio" name="participacao_ministerio" required class="input">
            <option value="Não">Não</option>
            <option value="Celebrações">Celebrações</option>
            <option value="Infantil">Infantil</option>
            <option value="UDF">UDF</option>
            <option value="MJF - Jovens">MJF - Jovens</option>
            <option value="MILAF - Louvor">MILAF - Louvor</option>
            <option value="MIDAF - Dança">MIDAF - Dança</option>
            <option value="Introdutores">Introdutores</option>
            <option value="Comunicação">Comunicação</option>
            <option value="Técnica">Técnica</option>
            <option value="Eventos/Cerimonial">Eventos/Cerimonial</option>
            <option value="Melhor Idade">Melhor Idade</option>
            <option value="Intercessão">Intercessão</option>
            <option value="Assistência Social">Assistência Social</option>
        </select>
        <label for="data_batismo">Data de Batismo:</label>
        <input type="date" id="data_batismo" name="data_batismo"  class="input">

        <label for="data_conversao">Data de Conversão:</label>
        <input type="date" id="data_conversao" name="data_conversao"  class="input">

        <label for="escolaridade">Escolaridade:</label>
        <select id="escolaridade" name="escolaridade" required class="input">
            <option value="Nenhum">Nenhum</option>
            <option value="Ensino fundamental">Ensino fundamental</option>
            <option value="Ensino médio">Ensino médio</option>
            <option value="Graduação">Graduação</option>
            <option value="Pós-graduação">Pós-graduação</option>
            <option value="Mestrado">Mestrado</option>
            <option value="Doutorado">Doutorado</option>
            <option value="Pós-doutorado">Pós-doutorado</option>
        </select>

        <label for="profissao">Profissão:</label>
        <input type="text" id="profissao" name="profissao" maxlength="75" required class="input">
        <!-- Inicio do formulario CEP autoincremento -->
        <label>CEP (Somente números):</label>
            <input name="cep" type="text" id="cep" value="" class="input" size="10" maxlength="9"
                onblur="pesquisacep(this.value);" /></label>

        <label>Rua:</label>
            <input class="input" name="rua" type="text" id="rua" size="60" /></label>

        <label>Bairro:</label>
            <input class="input" name="bairro" type="text" id="bairro" size="40" /></label>

        <label>Cidade:</label>
            <input class="input" name="cidade" type="text" id="cidade" size="40" /></label>

        <label>Estado:</label>
            <input class="input" name="uf" type="text" id="uf" size="2" /></label>

        <label>Número:</label>
            <input class="input" name="numero" type="text" id="numero" size="2" /></label>
        <label for="receber_noticias">Quer receber notícias da Igreja:</label>
        <select class="input" id="receber_noticias" name="receber_noticias" required>
            <option value="Sim">Sim</option>
            <option value="Não">Não</option>
        </select>
        <button type="submit" class="btn">Cadastrar Membro</button>
    </form> 
    </div>


    <!-- Adicionando Javascript -->
        <script>
        function limparCampos() {
            document.getElementById('base').value = "";
            document.getElementById('coordenacao').value = "";
            document.getElementById('supervisao').value = "";
            document.getElementById('supervisor').value = "";
            document.getElementById('celula').value = "";
            document.getElementById('lideres').value = "";
        }

        function preencherCamposCoordenacao(dados) {
            console.log('Dados recebidos:', dados);

            if (dados && dados.length > 0) {
                var coordenacao = dados[0];
                var nomeBase = coordenacao.Base;
                var nomeCoordenacao = coordenacao.Coordenacao;
                var nomeSupervisao = coordenacao.Supervisao;
                var nomeSupervisor = coordenacao.Supervisor;
                var nomeCelula = coordenacao.Celula;
                var nomesLideres = coordenacao.Lideres;

                document.getElementById('base').value = nomeBase;
                document.getElementById('coordenacao').value = nomeCoordenacao;
                document.getElementById('supervisao').value = nomeSupervisao;
                document.getElementById('supervisor').value = nomeSupervisor;
                document.getElementById('celula').value = nomeCelula;
                document.getElementById('lideres').value = nomesLideres;
            } else {
                alert("Dados da coordenação não encontrados.");
            }
        }
        //Funcao que busca os dados
        function buscarDados() {
            limparCampos();

            var numero_celula = document.getElementById('numero_celula').value;

            // Adicionar o número da célula no final
            fetch(`https://sistemaidpb.evoludesign.com.br/api/index.php?celula=${numero_celula}`)
                .then(response => response.json())
                .then(data => {
                    preencherCamposCoordenacao(data);
                })
                .catch(error => {
                    console.error('Erro na requisição:', error);
                    alert("Erro na requisição. Verifique o console para mais detalhes.");
                });
        }
    </script>
</body>

</html>
