// script.js
document.getElementById('mostrarSenha').addEventListener('change', function () {
    const passwordField = document.getElementById('senha');
    const isChecked = this.checked;
    passwordField.setAttribute('type', isChecked ? 'text' : 'password');
});
