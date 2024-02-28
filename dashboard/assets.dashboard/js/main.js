function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    var content = document.getElementById('content');
    sidebar.classList.toggle('active');
    content.classList.toggle('active');
}

function sairDiv(){
    window.location.href="/idpb/login";
}

function irRelatorio(){
    window.location.href="../relatorio-lideranca.php";
} 

function verRelatorio(){
    window.location.href="/idpb/graficos/presenca.php";
} 

function irCadastro(){
    window.location.href="/idpb/cadastro";
}
