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

function confirmarExclusao(id, idUsuarioExclusao) {
    if (confirm("Tem certeza disso?")) {
        $.ajax({
            url: '../v2/php/confirmar-exclusao.php',
            type: 'POST',
            data: {
                id,
                idUsuarioExclusao
            },
            success: function (response) {

                alert(response);
                location.reload();
                $('#mostrarGrade').html(response);
            },
            error: function (response) {
                alert(response);
                $('#mostrarGrade').html(response);
            }
        });
    }
}


function rejeitarExclusao(id, idUsuarioExclusao) {
    $.ajax({
        url: '../v2/php/rejeitar-exclusao.php',
        type: 'POST',
        data: {
            id,
            idUsuarioExclusao
        },
        success: function (response) {

            alert(response);
            location.reload();
            $('#mostrarGrade').html(response);
        },
        error: function (response) {
            alert(response);
            $('#mostrarGrade').html(response);
        }
    });
} 