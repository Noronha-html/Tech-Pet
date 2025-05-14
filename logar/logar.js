const checkbox = document.querySelector('#password-checkbox');
const passwordInput = document.querySelector('input[name="password"]');

checkbox.addEventListener('change', () => {
    passwordInput.type = checkbox.checked ? 'text' : 'password';
});
