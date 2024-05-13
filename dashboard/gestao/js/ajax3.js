$(document).ready(function () {
    $.ajax({
        url: '../v2/php/solicitacoes_exclusao.php',
        type: 'GET',
        success: function (response) {
            $('#mostrarGrade').html(response); 
        },
        error: function (xhr, status, error) {
            // $('#mostrarGrade').html(responseData);
        }
    });
}); 

function confirmarExclusao(){
    
    var formData = $(this).serialize();
    console.log('formData');
    
    $.ajax({
        url: '../v2/php/solicitacoes_exclusao.php',
        type: 'POST', 
        data: formData,
        
        // success: function(response){
            
        // }, 
        // error: function(){
        //     alert(response); 
        // }
    })
} 

function rejeitarExclusao(){
    alert('teste_rejddasdaseitar');
} 