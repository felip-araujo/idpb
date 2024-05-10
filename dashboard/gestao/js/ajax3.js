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
    alert('teste');
} 

function rejeitarExclusao(){
    alert('teste_rejeitar');
} 