function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    var content = document.getElementById('content');
    sidebar.classList.toggle('active');
    content.classList.toggle('active');
}

function sairDiv(){
    window.location.href="/idpb/login";
}