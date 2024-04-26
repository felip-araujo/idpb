function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    document.querySelector(".main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.querySelector(".main").style.marginLeft = "0";
}

$(document).ready(function() {
    $('#linkMembros').click(function(e) {
        e.preventDefault(); // Previne o comportamento padrão do link
        $('#loadingIcon').show(); // Mostra o ícone de carregamento
        // Carrega o conteúdo e depois esconde o ícone de carregamento
        $('#conteudoMembros').load('../gestao/membros.html', function() {
            $('#loadingIcon').hide(); // Esconde o ícone de carregamento
        });
        $('#fecharTabelaMembros').show();
            $(document).on('click', '#fecharTabelaMembros', function() {
                // Esconde o contêiner que tem a tabela de membros
                $('#conteudoMembros').empty(); // Remove o conteúdo ou
                //$('#conteudoMembros').hide(); // Apenas esconde o contêiner, dependendo da preferência
            });
    });
}); 

$(document).ready(function() {
    $('#linkCelulas').click(function(e) {
        e.preventDefault(); // Previne o comportamento padrão do link
        $('#loadingIcon').show(); // Mostra o ícone de carregamento
        // Carrega o conteúdo e depois esconde o ícone de carregamento
        $('#conteudoCelulas').load('../gestao/celulas.html', function() {
            $('#loadingIcon').hide(); // Esconde o ícone de carregamento
        });
        $('#fecharTabelaCelulas').show();
            $(document).on('click', '#fecharTabelaCelulas', function() {
                // Esconde o contêiner que tem a tabela de membros
                $('#conteudoCelulas').empty(); // Remove o conteúdo ou
                //$('#conteudoMembros').hide(); // Apenas esconde o contêiner, dependendo da preferência
            });
    });
}); 
