


$(document).on("ajaxComplete", function() {
    $(".log").text("Trigged ajaxComplete handler");
});

$( ".trigger" ).on( "click", function() {
    $( ".result" ).load( "ajax/test.html" );
  } );




// ajax.js
// $(document).ready(function() {
//     $('#alterar_funcao').on('submit', function(e) {
//         e.preventDefault(); // Evita o comportamento padrão de envio de formulários

//         $.ajax({
//             type: 'POST',
//             url: '../backend/processar_alterar_funcao.php', // Ajuste para a URL do seu script PHP
//             data: $(this).serialize(), // Serializa os dados do formulário
//             success: function(response) {
//                 // Aqui você manipula a resposta e atualiza o modal conforme necessário
//                 $('#alterar_funcao_membro').find('.modal-body').html(response); // Supondo que você quer inserir a resposta dentro do corpo do modal
//                 // Outras ações baseadas na resposta (por exemplo, mostrar/esconder o modal, limpar o formulário, etc.)
//             },
//             error: function(xhr, status, error) {
//                 // Tratamento de erro
//                 console.error("Ocorreu um erro: " + error);
//             }
//         });
//     });
// });

// $.ajax({
//     type: 'POST',
    url: '../backend/processar_alterar_funcao.php',
    data: $('#alterar_funcao').serialize(),
    dataType: 'json',  // Espera-se que a resposta seja JSON
    success: function(response) {
        if(response.message) {
            // Tratar sucesso
            alert(response.message);
        } else if(response.error) {
            // Tratar erro
            alert(response.error);
        }
    },
    error: function(xhr, status, error) {
        // Tratar erro na chamada AJAX
        console.error("Erro na requisição AJAX: " + error);
    }
});
