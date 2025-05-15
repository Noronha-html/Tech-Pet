const checkbox = document.querySelector('#password-checkbox');
const passwordInput = document.querySelector('input[name="password"]');
const userInput = document.querySelector('input[name="username"]');

checkbox.addEventListener('change', () => {
    passwordInput.type = checkbox.checked ? 'text' : 'password';
    checkbox.ariaChecked = true ? 'true' : 'false';
    checkbox.setAttribute('aria-checked', checkbox.checked);
});

function verificarInputs(){
    const user = userInput.value;
    const password = passwordInput.value;

    if(user === ""){
        alert("Preencha todos os campos!");
        return false;
    }
    if(password === ""){
        alert("Preencha todos os campos!");
        return false;
    }
    return true;
}
const btnEntrar = document.getElementById('buttonEntrar');
btnEntrar.addEventListener('click', () => {
    if(verificarInputs() === false){
        return;
    }else if(verificarInputs() === true){
        window.location = "../registre-se/registre-se.html"
    }
});

