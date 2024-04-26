$(document).ready(function () {
    $.ajax({
        url: '../gestao/backend/busca.php',
        type: 'GET',
        success: function (response) {
            $('#userSelect').html(response);
        },
        error: function () {
            $('#userSelect').html('<option>Erro ao carregar dados! </option>');
        }
    });
});

$(document).ready(function () {
    $.ajax({
        url: '../gestao/backend/busca-funcao.php',
        type: 'GET',
        success: function (response) {
            $('#function_Select').html(response);
        },
        error: function () {
            $('#function_Select').html('<option>Erro ao carregar funcoes! </option>');
        }
    });
});

//funnao para alterar a funcao do usuario 
$(document).ready(function () {
    $('#alterarFuncao').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        

        $.ajax({
            url: '../gestao/backend/processar_alterar_funcao.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#responseAlterarFuncao').html(response)
            }, error: function () {
                $('#responseAlterarFuncao').html('Erro ao enviar solicitação')
            }
        });
    });
});


//funcao para pegar os dados de membros em tabela e exibir em 'membros.html'
$(document).ready(function(){
    $.ajax({
        url: '../gestao/backend/busca_membros.php',
        type: 'GET',
        success:function(response){
            $('#responseMembers').html("<table>" + response + "</table>");
        },
        error: function(){
            $('#responseMembers').html("<p>Ocorreu um erro ao tentar carregar os dados.</p>")
        }
    })
})


//funcao para pegar os dados de celulas em tabela e exibir em 'celulas.html'
$(document).ready(function(){
    $.ajax({
        url: '../gestao/backend/busca_celulasXmembros.php',
        type: 'GET',
        success:function(response){
            $('#responseCelulas').html("<table>" + response + "</table>");
        },
        error: function(){
            $('#responseCelulas').html("<p>Ocorreu um erro ao tentar carregar os dados.</p>")
        }
    })
}) 

$(document).ready(function() {
    $("#exportarCSV").click(function() {
        var csv = [];
        var rows = $("table tr");

        rows.each(function() {
            var row = [];
            $(this).find("td, th").each(function() {
                var texto = $(this).text().replace(/"/g, '""'); // Aspas duplas escapadas
                row.push('"' + texto + '"'); // Aspas ao redor de cada campo
            });
            csv.push(row.join(","));
        });

        downloadCSV(csv.join("\n"), "membros.csv");
    });

    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        csvFile = new Blob([csv], {type: "text/csv"});
        downloadLink = $("<a></a>")
            .attr({
                'download': filename,
                'href': window.URL.createObjectURL(csvFile),
                'style': 'display:none;'
            });
        
        $("body").append(downloadLink);
        downloadLink[0].click();
        downloadLink.remove();
    }
});
