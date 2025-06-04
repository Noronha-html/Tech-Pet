const checkbox = document.getElementById('password-checkbox');
const passwordInput = document.getElementById('password');
const userInput = document.getElementById('username');

/*checkbox.addEventListener('change', () => {
    passwordInput.type = checkbox.checked ? 'text' : 'password';
    checkbox.ariaChecked = true ? 'true' : 'false';
    checkbox.setAttribute('aria-checked', checkbox.checked);
});*/


checkbox.addEventListener('change', () => {
    // alterna tipo do input entre "text" e "password"
    passwordInput.type = checkbox.checked ? 'text' : 'password';
    console.log(checkbox.checked);

    // atribui o valor correto ao aria-checked
    checkbox.ariaChecked = checkbox.checked ? 'true' : 'false';
    checkbox.setAttribute('aria-checked', checkbox.checked);
});

function verificarUsuario(){
    const user = document.getElementById("username");

    if(user.value === ""){
        return false;
    }
    
    return true;
}

function verificarSenha(){
    const password = document.getElementById("password");

    if(password.value === ""){
        return false;
    }

    /*if(password.length < 8){
        document.getElementById("label-password").innerHTML = "Senha <span style='color: red;'>*<span style='font-size: 0.8rem'>(Mínimo 8 caracteres)</span></span>";
        return false;
    }*/
    return true;
}

const btnEntrar = document.getElementById('buttonEntrar');
btnEntrar.addEventListener('click', (e) => {
    e.preventDefault();

    if(!verificarUsuario()){
        document.getElementById("label-user").innerHTML = "Usuário <span style='color: red;'>*<span style='font-size: 0.8rem'>(Obrigatório)</span></span>";
    }

    if(!verificarSenha()){
        document.getElementById("label-password").innerHTML = "Senha <span style='color: red;'>*<span style='font-size: 0.8rem'>(Obrigatório)</span></span>";
    }
    
    if(verificarUsuario() && verificarSenha()){
        //window.location.href = "../conta-usuario/conta-usuario.php";
        document.getElementById("formLogin").submit();
    }
});

