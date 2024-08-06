
document.getElementById('nova-senha').addEventListener('input', function () {
    var password = this.value;
    var criteria = {
        length: /.{8,}/,
        uppercase: /[A-Z]/,
        lowercase: /[a-z]/,
        number: /\d/,
        special: /[\W_]/
    };

    for (var criterion in criteria) {
        var regex = criteria[criterion];
        var element = document.getElementById(criterion);
        if (regex.test(password)) {
            element.classList.remove('invalid');
            element.classList.add('valid');
        } else {
            element.classList.remove('valid');
            element.classList.add('invalid');
        }
    }
});

function togglePasswordVisibility(fieldId) {
    var field = document.getElementById(fieldId);
    var icon = field.nextElementSibling.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}

function togglePasswordVisibilityConfirm(fieldId) {
    var field = document.getElementById(fieldId);
    var icon = field.nextElementSibling.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}