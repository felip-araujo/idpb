$(document).ready(function () {
    $.ajax({
        url: '../gestao/backend/busca.php',
        type: 'GET',
        success: function (response) {
            $('.userSelect').html(response);
        },
        error: function () {
            $('.userSelect').html('<option>Erro ao carregar dados! </option>');
        }
    });
});

$(document).ready(function () {
    $.ajax({
        url: '../gestao/backend/busca-funcao.php',
        type: 'GET',
        success: function (response) {
            $('.function_Select').html(response);
        },
        error: function () {
            $('.function_Select').html('<option>Erro ao carregar funcoes! </option>');
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
$(document).ready(function () {
    $.ajax({
        url: '../gestao/backend/busca_membros.php',
        type: 'GET',
        success: function (response) {
            $('#responseMembers').html("<table>" + response + "</table>");
        },
        error: function () {
            $('#responseMembers').html("<p>Ocorreu um erro ao tentar carregar os dados.</p>")
        }
    })
})

//Função para INSERIR UMA NOVA FUNÇÃO NA LIDERANÇA 
$(document).ready(function () {
    $('#inserirFuncao').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();;
        // console.log(formData);

        $.ajax({
            url: '../gestao/backend/processar_inserir_funcao.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#responseInserirFuncao').html(response)
            }, error: function () {
                $('#responseInserirFuncao').html('Erro ao enviar solicitação')
            }
        });
    });
});

//funcao para pegar os dados de celulas em tabela e exibir em 'celulas.html'
$(document).ready(function () {
    $.ajax({
        url: '../gestao/backend/busca_celulasXmembros.php',
        type: 'GET',
        success: function (response) {
            $('#responseCelulas').html("<table>" + response + "</table>");
        },
        error: function () {
            $('#responseCelulas').html("<p>Ocorreu um erro ao tentar carregar os dados.</p>")
        }
    })
})

//funcao para exibir tabela com usuarios / funcoes '

$(document).ready(function () {
    $.ajax({
        url: '../gestao/backend/busca-usuarios-lista.php',
        type: 'GET',
        success: function (response) {
            $('#gradeUsuarios').html("<table>" + response + "</table>");
        },
        error: function () {
            $('#gradeUsuarios').html("<p>Ocorreu um erro ao tentar carregar os dados.</p>")
        }
    })
})


function editUser() {
    alert("teste edit");
}



function deleteUser(userId) {
    if (confirm("Tem certeza que deseja excluir este usuário?")) {
        $.ajax({
            type: "POST",
            url: "../gestao/backend/processar_deletar_usuario.php",
            data: { deleteUserId: userId }, 
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                alert(response);
                console.error(xhr.responseText);
            }
        });
    }
}





$(document).ready(function () {
    $("#exportarCSV").click(function () {
        var csv = [];
        var rows = $("table tr");

        rows.each(function () {
            var row = [];
            $(this).find("td, th").each(function () {
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

        csvFile = new Blob([csv], { type: "text/csv" });
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
