const checkbox = document.getElementById('password-checkbox');
const passwordInput = document.getElementById('password');
const userInput = document.getElementById('username');

checkbox.addEventListener('change', () => {
    //Alterna tipo do input entre "text" e "password"
    passwordInput.type = checkbox.checked ? 'text' : 'password';
    console.log(checkbox.checked);

    //Atribui o valor correto ao aria-checked
    checkbox.ariaChecked = checkbox.checked ? 'true' : 'false';
    checkbox.setAttribute('aria-checked', checkbox.checked);
});

//Validações de usuário e senha
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
    return true;
}

const btnEntrar = document.getElementById('buttonEntrar');
btnEntrar.addEventListener('click', (e) => {
    e.preventDefault();

    //Se o usuário ou senha não forem preenchidos, exibe mensagem de erro
    if(!verificarUsuario()){
        document.getElementById("label-user").innerHTML = "Usuário <span style='color: red;'>*<span style='font-size: 0.8rem'>(Obrigatório)</span></span>";
    }

    if(!verificarSenha()){
        document.getElementById("label-password").innerHTML = "Senha <span style='color: red;'>*<span style='font-size: 0.8rem'>(Obrigatório)</span></span>";
    }
    
    //Se estiver tudo certo, manda o formulário
    if(verificarUsuario() && verificarSenha()){
        document.getElementById("formLogin").submit();
    }
});

