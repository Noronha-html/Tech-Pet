const checkbox = document.querySelector('.checkbox-container input[type="checkbox"]');
const passwordInput = document.querySelector('input[name="password"]');

checkbox.addEventListener('change', () => {
    passwordInput.type = checkbox.checked ? 'text' : 'password';
});
