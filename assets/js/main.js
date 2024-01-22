window.addEventListener("scroll", function () {
    const header = document.querySelector(".header");
    const headerHeight = header.offsetHeight;
    const viewportHeight = window.innerHeight;
    const scrollPosition = window.scrollY;
    if (scrollPosition > viewportHeight) {
        header.classList.add("header-fixed");
    } else {
        header.classList.remove("header-fixed");
    }
});