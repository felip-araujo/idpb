


function abrirPopup(){
    URL="joinus.html"; 
    window.open(URL, 'janela', 'width=660, heigth=510, top=100, left=669, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
}


var menuButton = document.getElementById("menu-button"); 
var menu = document.getElementById("menu"); 

menuButton.addEventListener("click", function(){
    if (menu.style.display === "block") {
        menu.style.display = "none"; 
    }  else {
        menu.style.display = "block"; 
    }
}); 