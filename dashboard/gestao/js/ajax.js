
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

$(document).ready(function () {
    $('#alterar-funcao').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        

        $.ajax({
            url: '../gestao/backend/processar_alterar_funcao.php',
            type: 'POST',
            data: formData,
            success:function(response){
                $('#responseDiv').html(response);
            },
            error:function(){
                $('#responseDiv').html('erro ao enviar dados');
            }
        })
    })

})