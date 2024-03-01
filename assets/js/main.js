document.addEventListener('DOMContentLoaded', function() {
    const viewportHeight = window.innerHeight;
    const viewportCalc = viewportHeight - 120;

    // alteraFundoDaHeader
    window.addEventListener("scroll", function() {
        const scrollPosition = window.scrollY;
        
        if (scrollPosition > viewportCalc) {
            fixHeader();
        } else {
            unfixHeader();
        }
    });
})


function fixHeader() {
    const header = document.querySelector(".header");
    header.classList.add("header--fixed");
}

function unfixHeader() {
    const header = document.querySelector(".header");
    header.classList.remove("header--fixed");
}