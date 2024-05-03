function checkboxLimit(checkBox, group) {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="' + group + '"]');
    checkboxes.forEach((item) => {
        if (item !== checkBox) item.checked = false;
    });
}