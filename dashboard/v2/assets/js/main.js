let sidebarOpen = true; // variável para controlar se a sidebar está aberta ou fechada

function toggleNav() {
    if (sidebarOpen) {
        closeNav();
        sidebarOpen = false;
    } else {
        openNav();
        sidebarOpen = true;
    }
}

function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    document.querySelector(".main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.querySelector(".main").style.marginLeft = "0";
}

// Adicione um evento de clique ao elemento que o usuário usará para abrir/fechar a sidebar
document.getElementById("toggleSidebarBtn").addEventListener("click", toggleNav);


$(document).ready(function () {
    $('#linkMembros').click(function (e) {
        e.preventDefault(); // Previne o comportamento padrão do link
        $('#loadingIcon').show(); // Mostra o ícone de carregamento
        // Carrega o conteúdo e depois esconde o ícone de carregamento
        $('#conteudoMembros').load('../gestao/membros.html', function () {
            $('#loadingIcon').hide(); // Esconde o ícone de carregamento
        });
        $('#fecharTabelaMembros').show();
        $(document).on('click', '#fecharTabelaMembros', function () {
            // Esconde o contêiner que tem a tabela de membros
            $('#conteudoMembros').empty(); // Remove o conteúdo ou
            //$('#conteudoMembros').hide(); // Apenas esconde o contêiner, dependendo da preferência
        });
    });
});

$(document).ready(function () {
    $('#linkCelulas').click(function (e) {
        e.preventDefault(); // Previne o comportamento padrão do link
        $('#loadingIcon').show(); // Mostra o ícone de carregamento
        // Carrega o conteúdo e depois esconde o ícone de carregamento
        $('#conteudoCelulas').load('../gestao/celulas.html', function () {
            $('#loadingIcon').hide(); // Esconde o ícone de carregamento
        });
        $('#fecharTabelaCelulas').show();
        $(document).on('click', '#fecharTabelaCelulas', function () {
            // Esconde o contêiner que tem a tabela de membros
            $('#conteudoCelulas').empty(); // Remove o conteúdo ou
            //$('#conteudoMembros').hide(); // Apenas esconde o contêiner, dependendo da preferência
        });
    });
});

function abrirSolicitacoes() {
    $('#solicitacoes').load('../gestao/solicitacoes.html', function () {
    })
}

function editarMembros() {
    $('#tables').load('../gestao/excluir-usuarios.html', function () {
    })
}


function showNotification(message, type) {
    var alertClass = 'alert-' + type;
    var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">'
        + message
        + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
        + '<button type="button" onclick="abrirSolicitacoes()" style="margin-left: .4rem;" class="btn btn-primary">Analisar</button>'
        + '</div>';
    $('.floating-alerts').append(alertHtml);
    $('.floating-alerts .alert').last().alert();
}

$(document).ready(function () {
    $.ajax({
        url: '../v2/php/processar_notificacoes.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                showNotification(response.message, 'info');
                if (response.data) {

                }
            } else {
                // showNotification(response.message, 'danger');
            }
        },
        error: function (xhr, status, error) {
            showNotification('Erro ao carregar notificações.', 'danger');
        }
    });
});

