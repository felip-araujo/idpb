$(document).ready(function () {
    $.ajax({
        url: '../gestao/backend/busca-funcao.php',
        type: 'GET',
        success: function (response) {
            $('#selecionar_Funcao').html(response);
        },
        error: function () {
            $('#selecionar_Funcao').html('<option>Erro ao carregar funcoes! </option>');
        }
    });
});

$(document).ready(function(){
    $.ajax({
        url:'../gestao/backend/busca_celula.php',
        type:'GET', 
        success: function(response){
            $('#num_celula').html(response);
        }, 
        error: function(){
            $('#num_celula').html('<option>Erro ao carregar células! </option>') 
        }

    })
})


$(document).ready(function(){
    $.ajax({
        url:'../gestao/backend/busca-supervisao.php',
        type:'GET', 
        success: function(response){
            $('#num_supervisao').html(response);
        }, 
        error: function(){
            $('#num_supervisao').html('<option>Erro ao carregar supervisao! </option>') 
        }

    })
})

$(document).ready(function(){
    $.ajax({
        url:'../gestao/backend/busca-coordenacao.php',
        type:'GET', 
        success: function(response){
            $('#num_coordenacao').html(response);
        }, 
        error: function(){
            $('#num_coordenacao').html('<option>Erro ao carregar coordenacao! </option>') 
        }

    })
})

$(document).ready(function(){
    $('#inserirUsuarios').submit(function(e){
        e.preventDefault(); 
        var formData = $(this).serialize();
        console.log(formData); 

        $.ajax({
            url:'../gestao/backend/processar_inserir_usuarios.php',
            type:"POST",
            data: formData, 
            success:function(response){
                $('#responseDiv').html(response);
            },
            error:function(){
                $('#responseDiv').html('Erro ao caadstrar usuário');
            }
        })
    })
})
